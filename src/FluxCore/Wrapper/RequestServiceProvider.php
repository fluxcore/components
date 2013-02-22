<?php

namespace FluxCore\Wrapper;

use FluxCore\Core\Service\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class RequestServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app['request'] = $this->app->share(function($app)
		{
			return Request::createFromGlobals();
		});
	}
}