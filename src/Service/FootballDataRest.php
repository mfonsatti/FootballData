<?php
/**
 * Created by PhpStorm.
 * User: mfonsatti
 * Date: 03/01/19
 * Time: 20:41
 */

namespace App\Service;

use App\Exception\FootballDataException;

/**
 * Class FootballDataRest
 * @package App\Service
 */
class FootballDataRest extends CurlCaller
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
     * FootballDataRest constructor.
     *
     * @param $apiToken
     * @param $baseUrl
     */
    public function __construct($apiToken, $baseUrl)
    {
        $this->apiToken = $apiToken;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $result
     *
     * @return array
     * @throws FootballDataException
     */
    protected function decodeResult(string $result): array
    {
        $response = json_decode($result, true);
        if (isset($response['error'])) {
            throw FootballDataException::invalidEntryPoint($response);
        }

        if (isset($response['errorCode'])){
            throw FootballDataException::invaliApiToken($response);
        }

        return $response;
    }

    /**
     * @param resource $curl
     * @param array $headers
     */
    protected function initCurlGet($curl, array &$headers): void
    {
        $headers[] = 'Content-type: application/json';
        $headers[] = 'X-Auth-Token: ' . $this->apiToken;
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
        return $this->baseUrl . $entryPoint;
    }
}