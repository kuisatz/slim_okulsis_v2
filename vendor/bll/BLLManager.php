<?php
/**
 *  Framework 
 *
 * @link       
 * @copyright Copyright (c) 2017
 * @license   
 */

namespace BLL;

/**
 * Business layer manager,
 * extended from Zend\ServiceManager\ServiceManager
 * @author Okan CIRAN 
 */
class BLLManager extends \Zend\ServiceManager\ServiceManager {
    
    /**
     * constructor
     * @param \Zend\ServiceManager\ConfigInterface $config
     */
    public function __construct(\Zend\ServiceManager\ConfigInterface $config = null) {
        parent::__construct($config);
    }
    
    /**
     * Attempt to create an instance via an invokable class
     * overriden Zend\ServiceManager\ServiceManager 'createFromInvokable' func.
     * @param  string $canonicalName
     * @param  string $requestedName
     * @return null|\stdClass
     * @throws Exception\ServiceNotFoundException If resolved class does not exist
     */
    protected function createFromInvokable($canonicalName, $requestedName)
    {
        $invokable = $this->invokableClasses[$canonicalName];
        if (!class_exists($invokable)) {
            throw new Exception\ServiceNotFoundException(sprintf(
                '%s: failed retrieving "%s%s" via invokable class "%s"; class does not exist',
                get_class($this) . '::' . __FUNCTION__,
                $canonicalName,
                ($requestedName ? '(alias: ' . $requestedName . ')' : ''),
                $invokable
            ));
        }
        $instance = new $invokable;
        $instance->setSlimApp($this->get('slimApp'));
        return $instance;
    }
    
    
}
