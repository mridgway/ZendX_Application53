<?php

namespace ZendX\Application53\Controller\Action\Helper;

/**
 * {@inheritdoc}
 */
class ViewRenderer extends \Zend_Controller_Action_Helper_ViewRenderer
{
    /**
     * View object basePath
     * @var string
     */
    protected $_viewBasePathSpec = ':moduleDir/View';

    /**
     * Overridden to allow for this 5.3 namespaced class. AbstractHelper parses by underscores.
     *
     * @return string
     */
    public function getName()
    {
        return 'ViewRenderer';
    }

    /**
     * Get module directory
     *
     * @throws Zend_Controller_Action_Exception
     * @return string
     */
    public function getModuleDirectory()
    {
        $module    = $this->getModule();
        $moduleDir = $this->getFrontController()->getControllerDirectory($module);
        $this->_moduleDir = dirname($moduleDir);
        return $this->_moduleDir;
    }
}