<?php

namespace FluxCore\Config;

use FluxCore\Config\Engine\PhpEngine;
use FluxCore\Core\Service\ServiceProvider;
use FluxCore\IO\FileFinder;

class ConfigServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app['config.resolver'] = $this->app->share(function($app)
		{
			$resolver = new EngineResolver();
			$resolver->add('php', new PhpEngine());

			return $resolver;
		});

		$this->app['config'] = $this->app->share(function($app)
		{
			return new ConfigManager(
				$app['config.resolver'],
				new FileFinder($app['config.path'])
			);
		});
	}
}