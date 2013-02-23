<?php

use Mockery as M;
use FluxCore\Core\Application;

class ApplicationTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		M::close();
	}

	public function testServiceRegistration()
	{
		$provider = M::mock('FluxCore\Core\ServiceProvider');
		$provider->shouldReceive('register')->once();

		$app = new Application;
		$app->register($provider);

		$this->assertTrue($app->isRegistered(get_class($provider)));
	}

	public function testConfigServiceRegistration()
	{
		$app = new Application;
		$app->registerConfigService();

		$this->assertTrue($app->isRegistered('FluxCore\Config\ConfigServiceProvider'));
	}

	public function testIlluminateCoreServicesRegistration()
	{
		$app = new Application;
		$app->registerIlluminateCoreServices();

		$this->assertTrue($app->isRegistered('Illuminate\Filesystem\FilesystemServiceProvider'));
		$this->assertTrue($app->isRegistered('Illuminate\Exception\ExceptionServiceProvider'));
		$this->assertTrue($app->isRegistered('Illuminate\Events\EventServiceProvider'));
	}
}