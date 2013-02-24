<?php

use Mockery as M;
use FluxCore\Core\Application;
use FluxCore\Core\ServiceManager;
use Illuminate\Events\EventServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplicationTest extends PHPUnit_Framework_TestCase
{
	public function testInitialize()
	{
		$app = new Application;
		$this->assertFalse($app->hasInitialized());

		$app->initialize(function($app)
		{
			$mock = M::mock('FluxCore\Core\ServiceProvider');
			$mock->shouldReceive('register')->once();

			$app['services']->register($mock);
		});

		$this->assertTrue($app->hasInitialized());
	}

	public function testEvent()
	{
		$app = new Application;
		$app->initialize(function($app) {
			$app['services']->register(new EventServiceProvider($app));
		});

		$app->event('test', function()
		{
			return 'Test';
		});

		$this->assertEquals(
			array('Test'),
			$app['events']->fire('app.test')
		);
	}

	public function testEventNotInitializedException()
	{
		$app = new Application;

		try {
			$app->event('test', function() {});
		} catch (RuntimeException $e) {
			$this->assertEquals(
				'Unable to bind application event as '.
				'$this[\'events\'] has not been defined',
				$e->getMessage()
			);

			return;
		}

		$this->fail('Expected RuntimeException was not raised.');
	}

	public function testRunNoRouterException()
	{
		$app = new Application;

		try {
			$app->run();
		} catch (RuntimeException $e) {
			$this->assertEquals(
				'Unable to run application as '.
				'$this[\'router\'] has not been defined',
				$e->getMessage()
			);

			return;
		}

		$this->fail('Expected RuntimeException was not raised.');
	}

	public function testPrepareRequestAndResponse()
	{
		$app = new Application;

		$request = Request::createFromGlobals();
		$request = $app->prepareRequest($request);
	}
}