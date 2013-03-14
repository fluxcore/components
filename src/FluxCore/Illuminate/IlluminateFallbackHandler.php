<?php

namespace FluxCore\Illuminate;

use FluxCore\Core\FallbackHandler;
use FluxCore\Exception\Handler as FluxExceptionHandler;
use Illuminate\Events\Dispatcher as EventDispatcher;
use Illuminate\Exception\Handler as ExceptionHandler;

/**
 * Illuminate application fallback handler.
 */
class IlluminateFallbackHandler extends FallbackHandler
{
	/**
	 * Method fallback.
	 *
	 * This method will bind an event based on the
	 * passed data.
	 * 
	 * @param string $name
	 * @param array $args
	 */
	function __call($name, $args)
	{
		if (sizeof($args) !== 1) {
			throw new \RuntimeException(
				'Invalid argument count for event binding.'
			);
		}

		$this->app['events']->listen("app.$name", $args[0]);
	}

	/**
	 * Dependency check.
	 */
	public function checkDependencies()
	{
		// $app['events']
		if (!isset($this->app['events'])) {
			return $this->missingDependency('$app[\'events\']');
		}

		// illuminate/events
		if (!$this->app['events'] instanceof EventDispatcher) {
			return $this->missingDependency('illuminate/events');
		}

		// $app['exception']
		if (!isset($this->app['exception'])) {
			return $this->missingDependency('$app[\'exception\']');
		}

		// illuminate/exception
		if (!$this->app['exception'] instanceof ExceptionHandler &&
			!$this->app['exception'] instanceof FluxExceptionHandler
		) {
			return $this->missingDependency('illuminate/exception');
		}
	}

	/**
	 * Prepare response.
	 *
	 * Fires the app.prepareResponse event.
	 * 
	 * @param mixed $response
	 * @param mixed $request
	 * @return mixed
	 */
	public function prepareResponse($response, $request)
	{
		$result = $this->app['events']->fire(
			'app.prepareResponse',
			array($this->app, $response, $request)
		);

		return isset($result[0]) ? $result[0] : null;
	}

	/**
	 * Prepare request.
	 *
	 * Fires the app.prepareRequest event.
	 * 
	 * @param mixed $request
	 * @return mixed
	 */
	public function prepareRequest($request)
	{
		$result = $this->app['events']->fire(
			'app.prepareRequest',
			array($this->app, $request)
		);

		return isset($result[0]) ? $result[0] : null;
	}

	/**
	 * Missing wrapper.
	 * 
	 * @param callable $callback
	 */
	public function missing($callback)
	{
		$this->error($callback);
	}

	/**
	 * Bind error handling callback.
	 * 
	 * @param Closure $callback
	 */
	public function error(\Closure $callback)
	{
		$this->app['exception']->error($callback);
	}
}