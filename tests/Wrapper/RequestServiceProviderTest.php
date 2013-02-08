<?php

use FluxCore\Core\Application;
use FluxCore\Wrapper\RequestServiceProvider;

class RequestServiceProviderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->app = new Application();
		$this->prov = new RequestServiceProvider($this->app);
	}

	public function testRegister()
	{
		$this->prov->register();

		$this->assertInstanceOf(
			'Symfony\Component\HttpFoundation\Request',
			$this->app['request']
		);
	}
}