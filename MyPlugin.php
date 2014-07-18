<?php
namespace My\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;	

class MyPlugin extends AbstractPlugin implements ServiceLocatorAwareInterface{

	private $services;
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->services = $serviceLocator;
	}

	public function getServiceLocator()
	{
		return $this->services;
	}

	public function getModel()
	{
		$service = $this->getServiceLocator();
		$adapter = $service->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$class = '\Application\Model\\QueueModel';
		return new $class($adapter, $service);
	}
	
}
