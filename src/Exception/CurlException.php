<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 04/01/19
 * Time: 10.03
 */

namespace App\Exception;

/**
 * Class CurlException
 * @package App\Exception
 */
class CurlException extends \Exception
{
    /**
     * @var mixed
     */
    private $result;

    /**
     * @var string
     */
    private $effectiveUrl;

    /**
     * @var string
     */
    private $method;

    /**
     * @var integer
     */
    private $httpStatus;

    /**
     * @param resource $curl
     * @param mixed $result
     */
    public function __construct($curl, $result = null)
    {
        $this->result = $result;
        $this->method = preg_match(
            '/^(get|post|put|delete|options)\s/i',
            curl_getinfo($curl, CURLINFO_HEADER_OUT),
            $match
        ) ? strtoupper($match[1]) : 'UNKNOWN';
        $this->httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->effectiveUrl = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
        curl_close($curl);

        parent::__construct(
            "Request {$this->method} {$this->effectiveUrl} termed with status {$this->httpStatus}",
            $this->httpStatus
        );
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getEffectiveUrl()
    {
        return $this->effectiveUrl;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return int
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }
}