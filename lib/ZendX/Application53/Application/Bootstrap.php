<?php

namespace ZendX\Application53\Application;

/**
 * {@inheritdoc}
 */
class Bootstrap extends \Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Adds ZendX\Application53 library to plugin prefix path
     *
     * @param ZendX\Application53\Application $application
     */
    public function __construct($application)
    {
        $this->getPluginLoader()->addPrefixPath(
            'ZendX\\Application53\\Application\\Resource\\',
            'ZendX/Application53/Application/Resource'
        );
        parent::__construct($application);
    }
}