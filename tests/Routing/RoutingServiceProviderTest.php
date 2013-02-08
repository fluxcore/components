<?php

use FluxCore\Core\Application;
use FluxCore\Routing\RoutingServiceProvider;

class RoutingServiceProviderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->app = new Application();
		$this->prov = new RoutingServiceProvider($this->app);
	}

	public function testRegister()
	{
		$this->prov->register();
		
		$this->assertInstanceOf(
			'FluxCore\Routing\Router',
			$this->app['router']
		);

		$this->assertInstanceOf(
			'FluxCore\Routing\Route\RouteCollection',
			$this->app['router.collection']
		);
	}
}