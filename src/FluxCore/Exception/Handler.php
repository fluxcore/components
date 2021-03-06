<?php

namespace FluxCore\Exception;

use Closure;
use ReflectionFunction;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler
{
	/**
	 * All of the register exception handlers.
	 *
	 * @var array
	 */
	protected $handlers = array();

	/**
	 * Handle a console exception.
	 *
	 * @param  Exception  $exception
	 * @return void
	 */
	public function handleConsole($exception)
	{
		return $this->handle($exception, true);
	}

	/**
	 * Handle the given exception.
	 *
	 * @param  Exception  $exception
	 * @param  bool  $fromConsole
	 * @return void
	 */
	public function handle($exception, $fromConsole = false)
	{
		foreach ($this->handlers as $handler)
		{
			// If this exception handler does not handle the given exception, we will
			// just go the next one. A Handler may type-hint the exception that it
			// will handle, allowing for more granularity on the error handling.
			if ( ! $this->handlesException($handler, $exception))
			{
				continue;
			}

			if ($exception instanceof HttpExceptionInterface)
			{
				$code = $exception->getStatusCode();
			}

			// If the exception doesn't implement the HttpExceptionInterface we will
			// just use the generic 500 error code for a server side error. If it
			// implements the Http interface we'll grab the error code from it.
			else
			{
				$code = 500;
			}

			// Return first handler available.
			// This means that we can't have multiple handlers per exception, but
			// we can more easily manage response from application.
			return $handler($exception, $code, $fromConsole);

			// COMMENTED AS ABOVE SOLUTION IS USED
			// If the handler returns a "non-null" response, we will return it so it
			// will get sent back to the browsers. Once a handler returns a valid
			// response we will cease iterating and calling the other handlers.
			//if ( ! is_null($response))
			//{
			//	return $response;
			//}
		}
	}

	/**
	 * Determine if the given handler handles this exception.
	 *
	 * @param  Closure    $handler
	 * @param  Exception  $exception
	 * @return bool
	 */
	protected function handlesException(Closure $handler, $exception)
	{
		$reflection = new ReflectionFunction($handler);

		return $reflection->getNumberOfParameters() == 0 or $this->hints($reflection, $exception);
	}

	/**
	 * Determine if the given handler type hints the exception.
	 *
	 * @param  ReflectionFunction  $reflection
	 * @param  Exception  $exception
	 * @return bool
	 */
	protected function hints(ReflectionFunction $reflection, $exception)
	{
		$parameters = $reflection->getParameters();

		$expected = $parameters[0];

		return ! $expected->getClass() or $expected->getClass()->isInstance($exception);
	}

	/**
	 * Register an application error handler.
	 *
	 * @param  Closure  $callback
	 * @return void
	 */
	public function error(Closure $callback)
	{
		array_unshift($this->handlers, $callback);
	}
}