<?php

namespace ZendX\Application53\Application\Resource;

require_once('ZendX/Application53/Init.php');

class ViewTest extends \Zend_Application_Resource_ViewTest
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

        \Zend_Controller_Action_HelperBroker::resetHelpers();
    }

    public function testHelperBrokerHasCorrectViewRenderer()
    {
        $resource = new \ZendX\Application53\Application\Resource\View(array());
        $resource->init();
        $viewRenderer = \Zend_Controller_Action_HelperBroker::getExistingHelper('viewRenderer');
        $this->assertEquals('ZendX\Application53\Controller\Action\Helper\ViewRenderer', get_class($viewRenderer));
    }
}