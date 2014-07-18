<?php
namespace My\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin,
	My\Controller\Plugin\MyPlugin;

use Zend\Cache\StorageFactory;

class MyCache extends MyPlugin {

	protected $function;
	protected $sm;
	protected $mvcEvent;
	protected $route;

	public function __invoke($function, $sm, $mvcEvent, $route)
	{
		$this->function = $function;
		$this->sm = $sm;
		$this->mvcEvent = $mvcEvent;
		$this->route = $route;
		return $this->$function($function, $sm, $mvcEvent, $route);
	}

	private function getRouterPermission()
	{
		$auth = $this->sm->get('viewhelpermanager')->get('Auth');
		$cusu_id = $auth('cusu_id');

		$route = $this->route->getParams();
		$route = $this->route['controller'].'\\'.$this->route['action'];
		var_dump ($route);
			die();

		// Parametros
		// $paramX1 = isset($route['paramX1']) ? $route['paramX1'] : '';
		// $paramX2 = isset($route['paramX2']) ? $route['paramX2'] : '';

		/* ***** criar sua logica com as rotas ou controller/action habilitados
		/* ***** ou se preferir, criar sua logica para gerar cache ou nao
		/* ***** Se o usuario estiver logado ou nao, voce e quem manda
		******** Se a rota nao estiver habilitada return false;	
		*
		*
		*/
		$habilitadas = array('');
		return false;

		return true;
	}

	public function get($function, $sm, $route)
	{
		if(!$this->getRouterPermission())
			return;

		if($function == 'get'){
			$cacheAdapter = $sm->get('Zend\Cache\Storage\Filesystem');
			if(($contents = $cacheAdapter->getItem('company_home')) == FALSE) {
				return false;
			}
			$this->mvcEvent->stopPropagation(true);
			echo (unserialize($contents));
			die();
			return unserialize($contents);
		}

	}

	public function save($function, $sm, $route)
	{
		if(!$this->getRouterPermission())
			return;
		$cacheAdapter = $this->sm->get('Zend\Cache\Storage\Filesystem');
		if(($contents = $cacheAdapter->getItem('company_home')) == FALSE) {
			$contents = serialize($this->mvcEvent->getResponse()->getContent());
			$cacheAdapter->setItem('company_home',  $contents );
		}
		return true;
	}

	public function removeItem($id)
	{
		if(!$id)
			return;
		$this->sm->get('Zend\Cache\Storage\Filesystem')->removeItem($id);
	}

}
