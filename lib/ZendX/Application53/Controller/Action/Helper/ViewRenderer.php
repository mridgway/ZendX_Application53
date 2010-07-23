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
}