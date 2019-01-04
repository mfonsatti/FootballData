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
     * @var string
     */
    protected $apiToken;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var CacheItemPoolInterface
     */
    protected $cache;

    /**
     * @param string $result
     *
     * @return array
     */
    abstract protected function decodeResult(string $result): array;

    /**
     * @param resource $curl
     * @param array $headers
     */
    abstract protected function initCurlGet($curl, array &$headers): void;

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
     *
     * @return mixed
     * @throws CurlException
     */
    public function doGet(string $entryPoint, array $headers = [])
    {
        $curl = $this->curl($entryPoint);
        $this->initCurlGet($curl, $headers);

        return $this->request($curl, $headers);
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
     *
     * @return mixed
     * @throws CurlException
     */
    protected function request($curl, $headers)
    {
        $this->beforeRequest($curl, $headers);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (200 <= $code and $code <= 299) {
            curl_close($curl);

            return $this->decodeResult($result);
        }
        throw new CurlException($curl, $result);
    }
}
