<?php

namespace FluxCore\Core;

use Illuminate\Support\ServiceProvider;

/**
 * Service manager class.
 */
class ServiceManager
{
	/**
	 * Has the services been booted yet?
	 * 
	 * @var boolean
	 */
	protected $booted = false;

	/**
	 * The service provider buffer.
	 * 
	 * @var array
	 */
	protected $serviceProviders = array();

	/**
	 * Register service provider.
	 * 
	 * @param Illuminate\Support\ServiceProvider $provider
	 */
	public function register(ServiceProvider $provider)
	{
		// Register service provider.
		$provider->register();

		// Store service provider.
		$this->serviceProviders[get_class($provider)] = $provider;
	}

	/**
	 * Is the service provider registered?
	 * 
	 * @param string $class
	 * @return boolean
	 */
	public function isRegistered($class)
	{
		return isset($this->serviceProviders[$class]);
	}

	/**
	 * Boot services.
	 */
	public function boot()
	{
		// Do not boot if the ServiceManager has booted
		// the providers before.
		if ($this->booted) {
			return;
		}

		// Boot each service provider.
		foreach ($this->serviceProviders as $provider) {
			$provider->boot();
		}

		// We have now booted the providers.
		$this->booted = true;
	}

	/**
	 * Has the services been booted yet?
	 * 
	 * @return boolean
	 */
	public function hasBooted()
	{
		return $this->booted;
	}
}