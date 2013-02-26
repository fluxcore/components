<?php

namespace FluxCore\Illuminate;

use FluxCore\Core\FallbackHandler;
use Illuminate\Events\Dispatcher as EventDispatcher;
use Illuminate\Exception\Handler as ExceptionHandler;

class IlluminateFallbackHandler extends FallbackHandler
{
	function __call($name, $args)
	{
		if (sizeof($args) !== 1) {
			throw new \RuntimeException(
				'Invalid argument count for event binding.'
			);
		}

		$this->app['events']->listen("app.$name", $args[0]);
	}

	public function checkDependencies()
	{
		// $app['events']
		if (!isset($this->app['events'])) {
			$this->missingDependency('$app[\'events\']');
		}

		// illuminate/events
		if (!$this->app['events'] instanceof EventDispatcher) {
			$this->missingDependency('illuminate/events');
		}

		// $app['exception']
		if (!isset($this->app['exception'])) {
			$this->missingDependency('$app[\'exception\']');
		}

		// illuminate/exception
		if (!$this->app['exception'] instanceof ExceptionHandler) {
			$this->missingDependency('illuminate/exception');
		}
	}

	public function prepareResponse($response, $request)
	{
		$result = $this->app['events']->fire(
			'app.prepareResponse',
			array($this->app, $response, $request)
		);

		return isset($result[0]) ? $result[0] : null;
	}

	public function prepareRequest($request)
	{
		$result = $this->app['events']->fire(
			'app.prepareRequest',
			array($this->app, $request)
		);

		return isset($result[0]) ? $result[0] : null;
	}

	public function missing($callback)
	{
		$this->error($callback);
	}

	public function error(\Closure $callback)
	{
		$this->app['exception']->error($callback);
	}
}