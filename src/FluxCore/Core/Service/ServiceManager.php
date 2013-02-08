<?php

namespace FluxCore\Core\Service;

use FluxCore\Core\Application;
use Illuminate\Support\ServiceProvider as IlluminateProvider;

class ServiceManager
{
	protected $app;
	protected $services = array();

	function __construct(Application $app = null)
	{
		$this->app = $app;
	}

	public function has($class)
	{
		return isset($this->services[$class]);
	}

	public function add($class)
	{
		if($this->has($class)) {
			return;
		}

		if(!class_exists($class)) {
			throw new \RuntimeException("'$class' does not exist.");
		}

		$service =& $this->services[$class];
		$service = new $class($this->app);
		if(	!($service instanceof ServiceProvider) &&
			!($service instanceof IlluminateProvider)
		) {
			throw new \RuntimeException(
				"'$class' is not a valid service provider."
			);
		}

		$service->register();
	}

	public function remove($class)
	{
		if(!$this->has($class)) {
			return;
		}

		unset($this->services[$class]);
	}
}