<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 04/01/19
 * Time: 10.28
 */

namespace App\Exception;

/**
 * Class FootballDataException
 * @package App\Exception
 */
class FootballDataException extends \Exception
{
    /**
     * FootballDataException constructor.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        parent::__construct($response['message'], $response['code']);
    }

    /**
     * @param $response
     *
     * @return FootballDataException
     */
    public static function invalidEntryPoint($response): self
    {
        return new self([
            'Your request was malformed',
            $response['error']
        ]);
    }

    /**
     * @param $response
     *
     * @return FootballDataException
     */
    public static function invaliApiToken($response): self
    {
        return new self([
            $response['message'],
            $response['errorCode']
        ]);
    }
}
