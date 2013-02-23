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

	public function testIlluminateCoreRegistration()
	{
		$app = new Application;
		$app->registerIlluminateCore();

		$this->assertTrue($app->isRegistered('Illuminate\Filesystem\FilesystemServiceProvider'));
		$this->assertTrue($app->isRegistered('Illuminate\Exception\ExceptionServiceProvider'));
		$this->assertTrue($app->isRegistered('Illuminate\Events\EventServiceProvider'));
	}
}