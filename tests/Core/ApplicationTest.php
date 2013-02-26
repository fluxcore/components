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

	public function testRun()
	{
		$app = new Application;
		$this->assertFalse($app->hasRun());

		$app->run(function($app, $request)
		{
			$router = M::mock('stdClass');
			$router->shouldReceive('dispatch')->once();

			$router->dispatch();
		});

		$this->assertTrue($app->hasRun());
	}

	public function testBindingOfPaths()
	{
		$app = new Application;
		$app->bindPaths(array('app' => '/', 'base' => '/path'));

		$this->assertEquals('/', $app['path']);
		$this->assertEquals('/path', $app['path.base']);
	}

	public function testSuccessfulFallback()
	{
		$app = new Application;
		$app->setFallbackHandler(new StubFallbackHandler());

		$this->assertInstanceOf('StubFallbackHandler', $app->getFallbackHandler());
		$this->assertEquals('Fallback Return', $app->fallbackMethod());
	}

	public function testFallbackNoHandlerAssignedException()
	{
		$app = new Application;

		try {
			$app->fallbackMethod();
		} catch (RuntimeException $e) {
			$this->assertEquals(
				"Can't perform fallback operation as no fallback handler has been assigned.",
				$e->getMessage()
			);

			return;
		}

		$this->fail('Expected RuntimeException has not been raised.');
	}
}

class StubFallbackHandler
{
	public function fallbackMethod()
	{
		return 'Fallback Return';
	}
}