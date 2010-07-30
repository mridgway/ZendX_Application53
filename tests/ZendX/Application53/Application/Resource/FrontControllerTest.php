<?php

namespace ZendX\Application53\Application\Resource;

require_once('ZendX/Application53/Init.php');

class FrontControllerTest extends \Zend_Application_Resource_FrontcontrollerTest
{

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

        require_once 'ZfAppBootstrap.php';
        $this->bootstrap = new \ZfAppBootstrap($this->application);
    }

    public function testInitializationPushesFrontControllerToBootstrapWhenPresent()
    {
        $resource = new \ZendX\Application53\Application\Resource\Frontcontroller(array());
        $resource->setBootstrap($this->bootstrap);
        $resource->init();
        $this->assertSame($resource->getFrontController(), $this->bootstrap->frontController);
    }

    public function testShouldSetControllerDirectoryWhenStringOptionPresent()
    {
        $resource = new \ZendX\Application53\Application\Resource\Frontcontroller(array(
            'controllerDirectory' => dirname(__FILE__),
        ));
        $resource->init();
        $front = $resource->getFrontController();
        $dir   = $front->getControllerDirectory('Core');
        $this->assertEquals(dirname(__FILE__), $dir);
    }

    public function testShouldSetModuleDirectoryWhenOptionPresent()
    {
        $resource = new \ZendX\Application53\Application\Resource\Frontcontroller(array(
            'moduleDirectory' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
                               . '_files' . DIRECTORY_SEPARATOR . 'modules',
        ));
        $resource->init();
        $front = $resource->getFrontController();
        $dir   = $front->getControllerDirectory();
        $expected = array(
            'Bar'     => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
                       . '_files' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR
                       . 'Bar' . DIRECTORY_SEPARATOR . 'Controller',
            'Core' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
                       . '_files' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR
                       . 'Core' . DIRECTORY_SEPARATOR . 'Controller',
            'FooBar' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
                       . '_files' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR
                       . 'FooBar' . DIRECTORY_SEPARATOR . 'Controller',
            'Foo'     => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
                       . '_files' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR
                       . 'Foo' . DIRECTORY_SEPARATOR . 'Controller',
            'Baz'     => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
                       . '_files' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR
                       . 'Baz' . DIRECTORY_SEPARATOR . 'Controller',
            'ZfAppBootstrap' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
                              . '_files' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR
                              . 'ZfAppBootstrap' . DIRECTORY_SEPARATOR . 'Controller',
        );
        $this->assertEquals($expected, $dir);
    }

    public function testShouldSetModuleControllerDirectoryNameWhenOptionPresent()
    {
        $resource = new \ZendX\Application53\Application\Resource\Frontcontroller(array(
            'moduleControllerDirectoryName' => 'foo',
        ));
        $resource->init();
        $front = $resource->getFrontController();
        $dir   = $front->getModuleControllerDirectoryName();
        $this->assertEquals('foo', $dir);
    }
}