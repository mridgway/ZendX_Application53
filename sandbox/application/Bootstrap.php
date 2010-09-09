<?php

class Bootstrap extends \ZendX\Application53\Application\Bootstrap
{
    public function _initCoreAutoloader()
    {
        \Zend_Loader_Autoloader::getInstance()->registerNamespace('Core');
    }
}