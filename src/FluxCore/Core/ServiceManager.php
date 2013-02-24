<?php

namespace FluxCore\Core;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceManager
{
	protected $booted = false;
	protected $serviceProviders = array();

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

	public function hasBooted()
	{
		return $this->booted;
	}
}