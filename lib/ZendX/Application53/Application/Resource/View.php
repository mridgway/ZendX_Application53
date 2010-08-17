<?php

namespace ZendX\Application53\Application\Resource;

/**
 * {@inheritdoc}
 */
class View extends \Zend_Application_Resource_View
{
    /**
     * {@inheritdoc}
     *
     * @return Zend_View
     */
    public function init()
    {
        $view = $this->getView();

        $viewRenderer = new \ZendX\Application53\Controller\Action\Helper\ViewRenderer();
        $viewRenderer->setView($view);
        \Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

        return $view;
    }
}