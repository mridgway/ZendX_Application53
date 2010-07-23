<?php

namespace ZendX\Application53\Controller\Dispatcher;

/**
 * {@inheritdoc}
 */
class Standard extends \Zend_Controller_Dispatcher_Standard
{

    /**
     * Default module
     * @var string
     */
    protected $_defaultModule = 'Core';

    /**
     * The namespace that contains the controllers inside of a module
     *
     * @var string
     */
    protected $_controllerNamespace = 'Controller';

    /**
     * {@inheritdoc}
     *
     * @param Zend_Controller_Request_Abstract $request
     * @return string|false Returns class name on success
     */
    public function getControllerClass(\Zend_Controller_Request_Abstract $request)
    {
        $controllerName = $request->getControllerName();
        if (empty($controllerName)) {
            if (!$this->getParam('useDefaultControllerAlways')) {
                return false;
            }
            $controllerName = $this->getDefaultControllerName();
            $request->setControllerName($controllerName);
        }

        $className = $this->formatControllerName($controllerName);

        $controllerDirs      = $this->getControllerDirectory();
        $module = $this->formatModuleName($request->getModuleName());
        if ($this->isValidModule($module)) {
            $this->_curModule    = $module;
            $this->_curDirectory = $controllerDirs[$module];
        } elseif ($this->isValidModule($this->_defaultModule)) {
            $request->setModuleName($this->_defaultModule);
            $this->_curModule    = $this->_defaultModule;
            $this->_curDirectory = $controllerDirs[$this->_defaultModule];
        } else {
            require_once 'Zend/Controller/Exception.php';
            throw new \Zend_Controller_Exception('No default module defined for this application');
        }
        return $className;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $unformatted
     * @return string
     */
    public function formatModuleName($unformatted)
    {
        if (($this->_defaultModule == $unformatted) && !$this->getParam('prefixDefaultModule')) {
            return $unformatted;
        }

        return ucfirst($this->_formatName($unformatted));
    }

    /**
     * {@inheritdoc}
     *
     * @param string $className
     * @return string Class name loaded
     * @throws Zend_Controller_Dispatcher_Exception if class not loaded
     */
    public function loadClass($className)
    {
        $fullClass = $this->_curModule . '\\';
        if ($this->getControllerNamespace()) {
            $fullClass .= $this->getControllerNamespace() . '\\';
        }
        $fullClass .= $className;

        $dispatchDir = $this->getDispatchDirectory();
        $loadFile    = $dispatchDir . DIRECTORY_SEPARATOR . $this->classToFilename($className);

        if (!class_exists($fullClass, true)) {
            throw new \Zend_Controller_Dispatcher_Exception('Invalid controller class ("' . $fullClass . '")');
        }

        return $fullClass;
    }

    /**
     * Set the namespace(and folder name) for controllers
     *
     * @param string $namespace
     * @return Standard
     */
    public function setControllerNamespace($namespace)
    {
        $this->_controllerNamespace = $namespace;
        return $this;
    }

    /**
     * Get the namespace(and folder name) for controllers
     *
     * @return string
     */
    public function getControllerNamespace()
    {
        return $this->_controllerNamespace;
    }
}