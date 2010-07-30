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
     * @param Zend_Controller_Request_Abstract $action
     * @return boolean
     */
    public function isDispatchable(\Zend_Controller_Request_Abstract $request)
    {
        $className = $this->getControllerClass($request);

        if (!$className) {
            return false;
        }

        $finalClass  = $this->getFullClass($className);

        if (class_exists($finalClass, false)) {
            return true;
        }

        $fileSpec    = $this->classToFilename($className);
        $dispatchDir = $this->getDispatchDirectory();
        $test        = $dispatchDir . DIRECTORY_SEPARATOR . $fileSpec;
        return \Zend_Loader::isReadable($test);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $class
     * @return string
     */
    public function classToFilename($class)
    {
        return str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    }

    /**
     * {@inheritdoc}
     *
     * @param string $unformatted
     * @return string
     */
    public function formatModuleName($unformatted)
    {
        foreach($this->getControllerDirectory() AS $moduleName => $directory) {
            if ($unformatted == strtolower($moduleName) || $unformatted == $moduleName) {
                return $moduleName;
            }
        }
        return $this->_formatName($unformatted);
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
        $fullClass = $this->getFullClass($className);

        if (!class_exists($fullClass, true)) {
            throw new \Zend_Controller_Dispatcher_Exception('Invalid controller class ("' . $fullClass . '")');
        }

        return $fullClass;
    }

    public function getFullClass($className)
    {
        $fullClass = $this->_curModule . '\\';
        if ($this->getControllerNamespace()) {
            $fullClass .= $this->getControllerNamespace() . '\\';
        }
        $fullClass .= $className;

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

    /**
     * {@inheritdoc}
     *
     * @param  string $module Module name
     * @return array|string Returns array of all directories by default, single
     * module directory if module argument provided
     */
    public function getControllerDirectory($module = null)
    {
        if (null !== $module) {
            $module = $this->formatModuleName($module);
        }
        return parent::getControllerDirectory($module);
    }
}