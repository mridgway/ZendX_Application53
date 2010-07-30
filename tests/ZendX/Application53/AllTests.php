<?php

namespace ZendX\Application53;

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'AllTests::main');
}

require_once __DIR__ . \DIRECTORY_SEPARATOR .'Init.php';

class AllTests
{
    public static function main()
    {
        \PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new \PHPUnit_Framework_TestSuite('ZendX Application53 Tests');

        $suite->addTestSuite('ZendX\Application53\ApplicationTest');
        $suite->addTestSuite('ZendX\Application53\Application\Resource\FrontControllerTest');
        $suite->addTestSuite('ZendX\Application53\Application\Resource\ModulesTest');
        $suite->addTestSuite('ZendX\Application53\Application\Resource\ViewTest');
        $suite->addTestSuite('ZendX\Application53\Application\BootstrapTest');
        //$suite->addTestSuite('ZendX\Application53\Controller\Dispatcher\StandardTest');
        //$suite->addTestSuite('ZendX\Application53\Controller\ActionTest');
        //$suite->addTestSuite('ZendX\Application53\Controller\FrontTest');

        return $suite;
    }
}