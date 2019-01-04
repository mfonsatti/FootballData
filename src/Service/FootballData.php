<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 03/01/19
 * Time: 14.20
 */

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class FootballData
 * @package App\Service
 */
class FootballData
{
    /**
     * @var string
     */
    protected $apiToken;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * FootballData constructor.
     *
     * @param string $apiToken
     * @param string $baseUrl
     */
    public function __construct(string $apiToken, string $baseUrl)
    {
        $this->apiToken = $apiToken;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $route
     *
     * @return mixed
     */
    public function curl(string $route)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $route);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            ['Content-type: application/json', 'X-Auth-Token: ' . $this->apiToken]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        return json_decode($response);
    }
}
