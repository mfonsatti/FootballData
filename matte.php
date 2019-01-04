<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 03/01/19
 * Time: 15.14
 */

require __DIR__ .'/vendor/autoload.php';

$kernel = new \App\Kernel('dev', false);
$kernel->boot();
$container = $kernel->getContainer();
/** @var \App\Service\FootballDataRest $footballData */
$footballData = $container->get('App\Service\FootballDataRest');
$matches = $footballData->doGet('matches');
$test = true;

