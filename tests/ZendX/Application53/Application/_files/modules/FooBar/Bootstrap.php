<?php

namespace FooBar;

class Bootstrap extends \Zend_Application_Module_Bootstrap
{
    public $bootstrapped = false;

    protected function _bootstrap($resource = null)
    {
        $this->bootstrapped = true;
        $this->getApplication()->fooBar = true;
    }
}