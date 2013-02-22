<?php

namespace FluxCore\Core\Service;

abstract class ServiceProvider
{
	protected $app;

	function __construct($app = null)
	{
		$this->app = $app;
	}

	abstract public function register();
	public function boot() { }
}