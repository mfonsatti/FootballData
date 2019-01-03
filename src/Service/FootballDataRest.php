<?php
/**
 * Created by PhpStorm.
 * User: mfonsatti
 * Date: 03/01/19
 * Time: 20:41
 */

namespace App\Service;

/**
 * Class FootballDataRest
 * @package App\Service
 */
class FootballDataRest extends CurlCaller
{
    /**
     * @param string $result
     * @param bool $checkSuccess
     *
     * @return array
     */
    protected function decodeResult(string $result, $checkSuccess): array
    {
        // TODO: Implement decodeResult() method.
    }

    /**
     * @param resource $curl
     * @param array $headers
     */
    protected function initCurlGet($curl, array &$headers): void
    {
        // TODO: Implement initCurlGet() method.
    }

    /**
     * @param resource $curl
     * @param array $headers
     */
    protected function initCurlDelete($curl, array &$headers): void
    {
        // TODO: Implement initCurlDelete() method.
    }

    /**
     * @param resource $curl
     * @param array $data
     * @param array $headers
     */
    protected function initCurlPost($curl, array $data, array &$headers): void
    {
        // TODO: Implement initCurlPost() method.
    }

    /**
     * @param resource $curl
     * @param array $data
     * @param array $headers
     */
    protected function initCurlPut($curl, array $data, array &$headers): void
    {
        // TODO: Implement initCurlPut() method.
    }

    /**
     * @param $curl
     * @param array $headers
     */
    protected function beforeRequest($curl, array &$headers): void
    {
        // TODO: Implement beforeRequest() method.
    }

    /**
     * @param string $entryPoint
     *
     * @return string
     */
    protected function composeURL(string $entryPoint): string
    {
        // TODO: Implement composeURL() method.
    }
}