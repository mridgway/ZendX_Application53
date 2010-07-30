<?php

namespace ZendX\Application53\Controller;

/**
 * {@inheritdoc}
 */
class Front extends \Zend_Controller_Front
{

    /**
     * Subdirectory within a module containing controllers; defaults to 'Controller'
     * @var string
     */
    protected $_moduleControllerDirectoryName = 'Controller';

    /**
     * {@inheritdoc}
     *
     * Overridden to provide a ZendX\Application53 ViewRenderer object
     *
     * @param \Zend_Controller_Request_Abstract $request
     * @param \Zend_Controller_Response_Abstract $response
     */
    public function dispatch(\Zend_Controller_Request_Abstract $request = null, \Zend_Controller_Response_Abstract $response = null)
    {
        if (!$this->getParam('noViewRenderer') && !\Zend_Controller_Action_HelperBroker::hasHelper('viewRenderer')) {
            \Zend_Controller_Action_HelperBroker::getStack()->offsetSet(-80, new \ZendX\Application53\Controller\Action\Helper\ViewRenderer());
        }
        parent::dispatch($request, $response);
    }
    
    /**
     * {@inheritdoc}
     *
     * @return Zend_Controller_Dispatcher_Interface
     */
    public function getDispatcher()
    {
        /**
         * Instantiate the default dispatcher if one was not set.
         */
        if (!$this->_dispatcher instanceof \Zend_Controller_Dispatcher_Interface) {
            $this->_dispatcher = new Dispatcher\Standard();
        }
        return $this->_dispatcher;
    }

    /**
     * {@inheritdoc}
     *
     * @return Zend_Controller_Front
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}