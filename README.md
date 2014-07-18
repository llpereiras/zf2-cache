zf2-cache
=========

ControllerPlugin para Zend framework 2 

Adicionem ao local, global ou criem um arquivo cache.local.php em config/autoload e adicionem suas configurações de cache

//// Ex: cache
	'Zend\Cache\Storage\Filesystem' => function($sm){
		$cache = Zend\Cache\StorageFactory::factory(array(
			'adapter' => 'filesystem',
			'plugins' => array(
				'exception_handler' => array('throw_exceptions' => false),
				'serializer'
			)
		));
		$cache->setOptions(array(
			'cache_dir' => './data/cache'
		));
		return $cache;
	},

// Adicionem os 2 controlesPlugins ao seu projeto
'controller_plugins' => array (
			'invokables' => array (
						'MyCache'  => 'My\Controller\Plugin\MyCache'
						)
	),
	
// adicione ao seu Module.php
		// loadcache
		$eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'loadCache'), 1);
		// salvecache
		$eventManager->attach(MvcEvent::EVENT_FINISH, array($this, 'loadCache'), -100);
    
	public function loadCache(MvcEvent $e)
	{
		return;
		if(MvcEvent::EVENT_ROUTE == 'route')
			$function = 'get';
		if(MvcEvent::EVENT_ROUTE == 'finish')
			$function = 'save';
			
		$application   = $e->getApplication();
		$sm			= $application->getServiceManager();
		$router = $sm->get('router');
		$request = $sm->get('request');
		$matchedRoute = $router->match($request);
		$sm->get('ControllerPluginManager')->get('MyCache')->get($function,$sm, $e, $matchedRoute);
	}
	
E seja feliz.

"Faster sites create happy users"
by google.
