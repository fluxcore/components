<?php

use FluxCore\Core\Application;
use FluxCore\Config\ConfigServiceProvider;

class ConfigServiceProviderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->app = new Application();
		$this->app['config.path'] = '';
		$this->prov = new ConfigServiceProvider($this->app);
	}

	public function testRegister()
	{
		$this->prov->register();
		
		$this->assertInstanceOf(
			'FluxCore\Config\ConfigManager',
			$this->app['config']
		);

		$this->assertInstanceOf(
			'FluxCore\Config\EngineResolver',
			$this->app['config.resolver']
		);
	}
}