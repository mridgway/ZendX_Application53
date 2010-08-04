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

    /**
     * {@inheritdoc}
     *
     * @return Zend_View
     */
    public function getView()
    {
        if (null === $this->_view) {
            $options = $this->getOptions();
            $this->_view = new \Zend_View($options);
            $this->_view->addHelperPath(APPLICATION_PATH . '/../library/ZendX/Application53/View/Helper', 'ZendX_Application53_View_Helper');

            if(isset($options['doctype'])) {
                $this->_view->doctype()->setDoctype(strtoupper($options['doctype']));
            }
        }
        return $this->_view;
    }
}