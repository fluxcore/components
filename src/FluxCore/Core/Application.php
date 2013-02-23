<?php

namespace FluxCore\Core;

use Closure;
use FluxCore\Config\ConfigServiceProvider;
use Illuminate\Container\Container;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Exception\ExceptionServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Application extends Container
{
	protected $booted = false;
	protected $serviceProviders = array();

	function __construct(Request $request = null)
	{
		// If a request was passed to the constructor, we use it.
		// Otherwise we create a new one from globals.
		$this['request'] = ($request)
			? $request
			: Request::createFromGlobals();
	}

	public function registerConfigService()
	{
		$this->register(new ConfigServiceProvider($this));
	}

	public function registerIlluminateCoreServices()
	{
		// This is to provide compatibility with Illuminate components as
		// most of them depend on these services.
		
		// illuminate/filesystem
		$this->register(new FilesystemServiceProvider($this));

		// illuminate/events
		$this->register(new EventServiceProvider($this));

		// illuminate/exception
		$this->register(new ExceptionServiceProvider($this));
	}

	public function register(BaseServiceProvider $provider)
	{
		// Register service provider.
		$provider->register();

		// Store service provider.
		$this->serviceProviders[get_class($provider)] = $provider;
	}

	public function isRegistered($class)
	{
		return isset($this->serviceProviders[$class]);
	}

	public function boot()
	{
		//
	}
}