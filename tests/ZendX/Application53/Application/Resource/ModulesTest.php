<?php

namespace ZendX\Application53\Application\Resource;

require_once('ZendX/Application53/Init.php');

class ModulesTest extends \Zend_Application_Resource_ModulesTest
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

        $this->application = new \ZendX\Application53\Application('testing');

        require_once 'ZfAppBootstrap.php';
        $this->bootstrap = new \ZfAppBootstrap($this->application);

        $this->front = \ZendX\Application53\Controller\Front::getInstance();
        $this->front->resetInstance();

        set_include_path(dirname(__FILE__) . '/../_files/modules' . \PATH_SEPARATOR . get_include_path());
    }

    public function testInitializationTriggersNothingIfNoModulesRegistered()
    {
        $this->bootstrap->registerPluginResource('Frontcontroller', array());
        $resource = new \ZendX\Application53\Application\Resource\Modules(array());
        $resource->setBootstrap($this->bootstrap);
        $resource->init();
        $this->assertFalse(isset($this->bootstrap->core));
        $this->assertFalse(isset($this->bootstrap->foo));
        $this->assertFalse(isset($this->bootstrap->bar));
    }

    /**
     * @group ZF-6803
     * @group ZF-7158
     */
    public function testInitializationTriggersDefaultModuleBootstrapWhenDiffersFromApplicationBootstrap()
    {
        $this->bootstrap->registerPluginResource('Frontcontroller', array(
            'moduleDirectory' => dirname(__FILE__) . '/../_files/modules',
        ));
        $resource = new \ZendX\Application53\Application\Resource\Modules(array());
        $resource->setBootstrap($this->bootstrap);
        $resource->init();
        $this->assertTrue(isset($this->bootstrap->core));
    }

    public function testInitializationShouldTriggerModuleBootstrapsWhenTheyExist()
    {
        $this->bootstrap->registerPluginResource('Frontcontroller', array(
            'moduleDirectory' => dirname(__FILE__) . '/../_files/modules',
        ));
        $resource = new \ZendX\Application53\Application\Resource\Modules(array());
        $resource->setBootstrap($this->bootstrap);
        $resource->init();
        $this->assertTrue($this->bootstrap->foo, 'foo failed');
        $this->assertTrue($this->bootstrap->bar, 'bar failed');
    }

    /**
     * @group ZF-6803
     * @group ZF-7158
     */
    public function testInitializationShouldSkipModulesWithoutBootstraps()
    {
        $this->bootstrap->registerPluginResource('Frontcontroller', array(
            'moduleDirectory' => dirname(__FILE__) . '/../_files/modules',
        ));
        $resource = new \ZendX\Application53\Application\Resource\Modules(array());
        $resource->setBootstrap($this->bootstrap);
        $resource->init();
        $bootstraps = $resource->getExecutedBootstraps();
        $this->assertEquals(4, count((array)$bootstraps));
        $this->assertArrayHasKey('Bar',     (array)$bootstraps);
        $this->assertArrayHasKey('FooBar', (array)$bootstraps);
        $this->assertArrayHasKey('Foo',     (array)$bootstraps);
        $this->assertArrayHasKey('Core', (array)$bootstraps);
    }

    /**
     * @group ZF-6803
     * @group ZF-7158
     */
    public function testShouldReturnExecutedBootstrapsWhenComplete()
    {
        $this->bootstrap->registerPluginResource('Frontcontroller', array(
            'moduleDirectory' => dirname(__FILE__) . '/../_files/modules',
        ));
        $resource = new \ZendX\Application53\Application\Resource\Modules(array());
        $resource->setBootstrap($this->bootstrap);
        $bootstraps = $resource->init();
        $this->assertEquals(4, count((array)$bootstraps));
        $this->assertArrayHasKey('Bar',     (array)$bootstraps);
        $this->assertArrayHasKey('FooBar', (array)$bootstraps);
        $this->assertArrayHasKey('Foo',     (array)$bootstraps);
        $this->assertArrayHasKey('Core', (array)$bootstraps);
    }
}