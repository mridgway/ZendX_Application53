# ZendX_Application53

This library's primary goal is extending Zend_Application to use PHP 5.3 namespaces. To simplify autoloading, the directory structure has been changed to match the application namespaces directly. The resource autoloader has been removed and instead we just add namespaces to Zend_Loader_Autoloader.

## Setting Up an Application

ZendX_Application53 tries to make the process of setting up an application with 5.3 namespaces as simple as possible. The following should be done to a new (or existing) ZF application to make it a 5.3 application:

1. Add namespace to all of your project files. See the 'Namespacing' section for details.
2. Change the directory structure to match what is shown in the 'Application Structure' section.
3. In your index.php or wherever you instantiate Zend_Application, replace the `Zend_Application` with `\ZendX\Application53\Application` (make sure the require is correct as well). See [index.php](http://github.com/mridgway/ZendX_Application53/blob/master/sandbox/public/index.php#L43)
4. Your application bootstrap should add 'Core' to the autoloader as in [Bootstrap.php](http://github.com/mridgway/ZendX_Application53/blob/master/sandbox/application/Bootstrap.php#L7). *Note: this is only necessary if your application bootstrap needs to load resources from your Core module.*


## Namespacing

ZF's module resource autoloader was inconsistent (Blog_IndexController vs Blog_Model_Article), but since we're now using a namespace autoloader, we don't have to worry about trying to figure out where the autoloader is trying to find things. In all cases, the namespaces match the directory structure (just replace '\' with '/' and add '.php' to the end).

All of the files in your application directory should be namespaced. The application root (or the module directory if specified) will become the root namespace `\`. The first level namespaces (e.g. `Blog`) are what will become your application's modules. Inside each module you should have 'Controller' and 'View' namespaces/directories and then any others that you need to add ('Model', 'Form', 'Validator', etc.)

The `Core` module replaces `default` as the default module since 'default' is a reserved word in PHP and cannot be used as a namespace.

To give an idea of what a controller will look like with namespaces, see the [IndexController in the Core module](http://github.com/mridgway/ZendX_Application53/blob/master/sandbox/application/Core/Controller/IndexController.php).

## Application Structure

The directory structure matches the namespacing directly with `application` being the root folder (root folder can be changed by setting moduleDirectory in application config).

The directory structure for Zend_Application has been changed from

    -application
        -default
            -controllers
                IndexController.php
                ErrorController.php
            -views
                -scripts
                    -index
                        index.phtml
                        action1.phtml
        -module1
            -..

to:

    -application
        -Core
            -Controller
                IndexController.php
                ErrorController.php
            -View
                -scripts
                    -index
                        index.phtml
                        action1.phtml
            Bootstrap.php
        -Module1
            -..
        Bootstrap.php

 
