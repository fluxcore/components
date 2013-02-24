<?php

use Mockery as M;
use FluxCore\Core\ServiceManager;

class ServiceManagerTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		M::close();
	}

	public function testServiceRegistration()
	{
		$provider = M::mock('FluxCore\Core\ServiceProvider');
		$provider->shouldReceive('register')->once();

		$services = new ServiceManager();
		$services->register($provider);

		$this->assertTrue($services->isRegistered(get_class($provider)));
	}

	public function testBoot()
	{
		$provider = M::mock('FluxCore\Core\ServiceProvider');
		$provider->shouldReceive('register')->once();
		$provider->shouldReceive('boot')->once();

		$services = new ServiceManager();
		$services->register($provider);
		$services->boot();

		$this->assertTrue($services->hasBooted());
	}
}