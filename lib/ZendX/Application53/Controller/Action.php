<?php

namespace ZendX\Application53\Controller;

/**
 * {@inheritdoc}
 */
class Action extends \Zend_Controller_Action
{
    /**
     * {@inheritdoc}
     *
     * Overridden to use the correct directory for view scripts
     *
     * @return Zend_View_Interface
     * @throws Zend_Controller_Exception if base view directory does not exist
     */
    public function initView()
    {
        if (!$this->getInvokeArg('noViewRenderer') && $this->_helper->hasHelper('viewRenderer')) {
            return $this->view;
        }
        
        if (isset($this->view) && ($this->view instanceof Zend_View_Interface)) {
            return $this->view;
        }

        $request = $this->getRequest();
        $module  = $request->getModuleName();
        $dirs    = $this->getFrontController()->getControllerDirectory();
        if (empty($module) || !isset($dirs[$module])) {
            $module = $this->getFrontController()->getDispatcher()->getDefaultModule();
        }
        $baseDir = dirname($dirs[$module]) . DIRECTORY_SEPARATOR . 'View';
        if (!file_exists($baseDir) || !is_dir($baseDir)) {
            throw new Zend_Controller_Exception('Missing base view directory ("' . $baseDir . '")');
        }
        
        $this->view = new Zend_View(array('basePath' => $baseDir));

        return $this->view;
    }
}