<?php

if (!defined('LIBRARY_PATH')) {
    define('LIBRARY_PATH', realpath( __DIR__
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . 'lib'));
}

if (!defined('TESTS_PATH')) {
    define('TESTS_PATH', realpath( __DIR__
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . '..'));
}

if (!defined('ZEND_PATH')) {
    define('ZEND_PATH', realpath( __DIR__
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . 'vendor'
                             . DIRECTORY_SEPARATOR . 'ZendFramework'
                             . DIRECTORY_SEPARATOR . 'library'));
}

if (!defined('ZEND_TEST_PATH')) {
    define('ZEND_TEST_PATH', realpath( __DIR__
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . 'vendor'
                             . DIRECTORY_SEPARATOR . 'ZendFramework'
                             . DIRECTORY_SEPARATOR . 'tests'));
}

if (!defined('SANDBOX_PATH')) {
    define('SANDBOX_PATH', realpath( __DIR__
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . '..'
                             . DIRECTORY_SEPARATOR . 'sandbox'
                             . DIRECTORY_SEPARATOR . 'application'));
}

set_include_path( LIBRARY_PATH . PATH_SEPARATOR
                . TESTS_PATH . PATH_SEPARATOR
                . ZEND_PATH . PATH_SEPARATOR
                . ZEND_TEST_PATH . PATH_SEPARATOR
                . SANDBOX_PATH . PATH_SEPARATOR
                . get_include_path()
                );

include('Zend/Loader/Autoloader.php');
\Zend_Loader_Autoloader::getInstance()->registerNamespace('ZendX');