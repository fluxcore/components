<?php

namespace FluxCore\Config;

use FluxCore\Core\Service\ServiceProvider;
use FluxCore\IO\FileFinder;

class ConfigServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app['config'] = $this->app->share(function($app)
		{
			return new ConfigManager(
				new EngineResolver(),
				new FileFinder($app['config.path'])
			);
		});
	}
}