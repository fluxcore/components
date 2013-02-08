<?php

namespace FluxCore\Routing;

use FluxCore\Core\Service\ServiceProvider;
use FluxCore\Routing\Route\RouteCollection;
use FluxCore\Routing\Route\RouteResolver;

class RoutingServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app['router.collection'] = $this->app->share(function($app)
		{
			return new RouteCollection();
		});

		$this->app['router'] = $this->app->share(function($app)
		{
			return new Router(
				$app['router.collection'],
				new RouteResolver($app['router.collection'])
			);
		});
	}
}