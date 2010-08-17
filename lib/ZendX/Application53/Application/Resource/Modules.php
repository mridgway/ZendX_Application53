<?php

namespace ZendX\Application53\Application\Resource;

/**
 * {@inheritdoc}
 */
class Modules extends \Zend_Application_Resource_Modules
{
    /**
     * {@inheritdoc}
     *
     * Overridden to allow namespaced bootstraps
     * 
     * @return array
     */
    public function init()
    {
        $bootstrap = $this->getBootstrap();
        $bootstrap->bootstrap('Frontcontroller');
        $front = $bootstrap->getResource('Frontcontroller');

        $modules = $front->getControllerDirectory();
        foreach ($modules as $module => $moduleDirectory) {
            $bootstrapClass = $module . '\\Bootstrap';
            $bootstrapPath  = dirname($moduleDirectory) . '/Bootstrap.php';
            if (file_exists($bootstrapPath)) {
                \Zend_Loader_Autoloader::getInstance()->registerNamespace($module);
                $moduleBootstrap = new $bootstrapClass($bootstrap);
                $moduleBootstrap->bootstrap();
                $this->_bootstraps[$module] = $moduleBootstrap;
            }
        }

        return $this->_bootstraps;
    }
}