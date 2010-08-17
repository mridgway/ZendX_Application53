<?php

namespace ZendX\Application53\Application\Resource;

/**
 * {@inheritdoc}
 */
class Frontcontroller extends \Zend_Application_Resource_Frontcontroller
{

    /**
     * {@inheritdoc}
     *
     * Overridden to use new front controller
     *
     * @return \ZendX\Application53\Controller\Front
     */
    public function getFrontController()
    {
        if (null === $this->_front) {
            $this->_front = \ZendX\Application53\Controller\Front::getInstance();
        }
        return $this->_front;
    }
}