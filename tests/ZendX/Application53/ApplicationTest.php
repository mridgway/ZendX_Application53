<?php

namespace ZendX\Application53;

require_once('ZendX/Application53/Init.php');

class ApplicationTest extends \Zend_Application_ApplicationTest
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

        // Store original include_path
        $this->includePath = get_include_path();

        \Zend_Loader_Autoloader::resetInstance();
        $this->autoloader = \Zend_Loader_Autoloader::getInstance();

        require_once('ZendX/Application53/Application.php');
        $this->application = new \ZendX\Application53\Application('testing');

        $this->iniOptions = array();
    }
    
    public function testConstructorAddsZendXNamespaceToAutoloader()
    {
        $this->assertContains('ZendX', $this->application->getAutoloader()->getRegisteredNamespaces());
    }
}