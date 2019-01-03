<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 03/01/19
 * Time: 18.09
 */

namespace App\Service;

use App\Exception\CurlException;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Class CurlCaller
 * @package App
 */
abstract class CurlCaller
{
    /**
     * @var CacheItemPoolInterface
     */
    protected $cache;

    /**
     * @param string $result
     * @param bool $checkSuccess
     *
     * @return array
     */
    abstract protected function decodeResult(string $result, $checkSuccess): array;

    /**
     * @param resource $curl
     * @param array $headers
     */
    abstract protected function initCurlGet($curl, array &$headers): void;

    /**
     * @param resource $curl
     * @param array $headers
     */
    abstract protected function initCurlDelete($curl, array &$headers): void;

    /**
     * @param resource $curl
     * @param array $data
     * @param array $headers
     */
    abstract protected function initCurlPost($curl, array $data, array &$headers): void;

    /**
     * @param resource $curl
     * @param array $data
     * @param array $headers
     */
    abstract protected function initCurlPut($curl, array $data, array &$headers): void;

    /**
     * @param $curl
     * @param array $headers
     */
    abstract protected function beforeRequest($curl, array &$headers): void;

    /**
     * @param string $entryPoint
     *
     * @return string
     */
    abstract protected function composeURL(string $entryPoint): string;

    /**
     * Rest constructor.
     *
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $entryPoint
     * @param array $headers
     * @param bool $checkSuccess
     *
     * @return mixed
     * @throws CurlException
     */
    public function doGet(string $entryPoint, array $headers = [], bool $checkSuccess = true)
    {
        $curl = $this->curl($entryPoint);
        $this->initCurlGet($curl, $headers);

        return $this->request($curl, $headers, $checkSuccess);
    }

    /**
     * @param string $entryPoint
     * @param array $headers
     * @param bool $checkSuccess
     *
     * @return mixed
     * @throws CurlException
     */
    public function doDelete(string $entryPoint, array $headers = [], bool $checkSuccess = true)
    {
        $curl = $this->curl($entryPoint);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        $this->initCurlDelete($curl, $headers);

        return $this->request($curl, $headers, $checkSuccess);
    }

    /**
     * @param string $entryPoint
     * @param array $data
     * @param array $headers
     * @param bool $checkSuccess
     *
     * @return mixed
     * @throws CurlException
     */
    public function doPost(string $entryPoint, array $data, array $headers = [], bool $checkSuccess = true)
    {
        $curl = $this->curl($entryPoint);
        $this->initCurlPost($curl, $data, $headers);

        return $this->request($curl, $headers, $checkSuccess);
    }

    /**
     * @param string $entryPoint
     * @param array $data
     * @param array $headers
     * @param bool $checkSuccess
     *
     * @return mixed
     * @throws CurlException
     */
    public function doPut(string $entryPoint, array $data, array $headers = [], bool $checkSuccess = true)
    {
        $curl = $this->curl($entryPoint);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        $this->initCurlPut($curl, $data, $headers);

        return $this->request($curl, $headers, $checkSuccess);
    }

    /**
     * @param string $entryPoint
     *
     * @return resource
     */
    protected function curl(string $entryPoint)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSLVERSION     => 6,
            CURLINFO_HEADER_OUT    => 1,
            CURLOPT_URL            => $this->composeURL($entryPoint)
        ]);

        return $curl;
    }

    /**
     * @param resource $curl
     * @param array $headers
     * @param bool $checkSuccess
     *
     * @return mixed
     * @throws CurlException
     */
    protected function request($curl, $headers, $checkSuccess)
    {
        $this->beforeRequest($curl, $headers);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (200 <= $code and $code <= 299) {
            curl_close($curl);

            return $this->decodeResult($result, $checkSuccess);
        }
        throw new CurlException($curl, $result);
    }
}
