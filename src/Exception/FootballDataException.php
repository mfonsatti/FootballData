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
     * @param $response
     *
     * @return FootballDataException
     */
    public static function invalidEntryPoint($response): self
    {

    }

    public static function invaliApiToken($response): self
    {

    }
}
