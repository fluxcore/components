<?php

use Mockery as M;
use FluxCore\Illuminate\IlluminateFallbackHandler;

class IlluminateFallbackHandlerTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->app = array();
		$app =& $this->app;

		$app['events'] = M::mock('Illuminate\Events\Dispatcher');
		$app['exception'] = M::mock('Illuminate\Exception\Handler');

		$this->handler = new IlluminateFallbackHandler($app);
	}

	public function tearDown()
	{
		M::close();
	}

	public function testPrepareRequest()
	{
		$this->app['events']->shouldReceive('fire')
			->with('app.prepareRequest', array($this->app, 'request'))
			->once()
			->andReturn(array('prepared request'));

		$request = $this->handler->prepareRequest('request');
		$this->assertEquals('prepared request', $request);
	}

	public function testPrepareResponse()
	{
		$this->app['events']->shouldReceive('fire')
			->with('app.prepareResponse', array($this->app, 'response', 'request'))
			->once()
			->andReturn(array('prepared response'));

		$response = $this->handler->prepareResponse('response', 'request');
		$this->assertEquals('prepared response', $response);
	}

	public function testError()
	{
		$callback = function() {};
		$this->app['exception']->shouldReceive('error')
			->with($callback)
			->once();

		$this->handler->error($callback);
	}

	public function testCallEventBindingWrapper()
	{
		$callback = function() {};
		$this->app['events']->shouldReceive('listen')
			->with('app.before', $callback)
			->once();

		$this->handler->before($callback);
	}

	public function testCallEventBindingWrapperInvalidArgumentCountException()
	{
		try {
			$this->handler->before();
		} catch (\RuntimeException $e) {
			$this->assertEquals(
				'Invalid argument count for event binding.',
				$e->getMessage()
			);

			return;
		}

		$this->fail('Expected RuntimeException was not raised.');
	}
}