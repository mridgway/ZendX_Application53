<?php

namespace ZendX\Application53\Application;

require_once('ZendX/Application53/Init.php');

class BootstrapTest extends \Zend_Application_Bootstrap_BootstrapTest
{
    public static $btest = false;
    public function setUp()
    {
        // Store original autoloaders
        $this->loaders = spl_autoload_functions();
        if (!is_array($this->loaders)) {
            // spl_autoload_functions does not return empty array when no
            // autoloaders registered...
            $this->loaders = array();
        }

        \Zend_Loader_Autoloader::resetInstance();
        $this->autoloader = \Zend_Loader_Autoloader::getInstance();

        require_once('ZendX/Application53/Application.php');
        $this->application = new \ZendX\Application53\Application('testing');
        $this->bootstrap   = new \ZendX\Application53\Application\Bootstrap(
            $this->application
        );

        $this->resetFrontController();
    }

    public function testRunShouldDispatchFrontController()
    {
        self::$btest=true;
        $this->bootstrap->setOptions(array(
            'resources' => array(
                'frontcontroller' => array(
                    'moduleDirectory' => dirname(__FILE__) . '/_files/modules',
                ),
            ),
        ));
        $this->bootstrap->bootstrap();

        $front   = $this->bootstrap->getResource('FrontController');

        $request = $front->getRequest();
        $request->setRequestUri('/zfappbootstrap');
        $this->bootstrap->run();

        $this->assertTrue($this->bootstrap->getContainer()->zfappbootstrap);
    }

    /**
     * @group ZF-7367
     */
    public function testBootstrapRunMethodShouldReturnResponseIfFlagEnabled()
    {
        self::$btest=true;
        $this->bootstrap->setOptions(array(
            'resources' => array(
                'frontcontroller' => array(
                    'moduleDirectory' => dirname(__FILE__) . '/_files/modules',
                    'returnresponse'  => true,
                ),
            ),
        ));
        $this->bootstrap->bootstrap();

        $front   = $this->bootstrap->getResource('FrontController');
        $request = $front->getRequest();
        $request->setRequestUri('/zfappbootstrap');

        $result = $this->bootstrap->run();
        $this->assertTrue($result instanceof \Zend_Controller_Response_Abstract);
    }

    /**
     */
    public function testRunShouldRaiseExceptionIfNoControllerDirectoryRegisteredWithFrontController()
    {
    }


    public function testFrontControllerResourcePluginShouldBeRegisteredByDefault()
    {
    }

    /**
     * @group ZF-8496
     */
    public function testBootstrapModuleAutoloaderShouldNotBeInitializedByDefault()
    {
    }

    /**
     * @group ZF-8496
     */
    public function testBootstrapShouldInitializeModuleAutoloaderWhenNamespaceSpecified()
    {
    }

    /**
     * @group ZF-8496
     */
    public function testBootstrapAutoloaderNamespaceShouldBeConfigurable()
    {
    }
}