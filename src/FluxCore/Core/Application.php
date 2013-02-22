<?php

namespace FluxCore\Core;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Exception\ExceptionServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Application extends Container
{
	protected $serviceProviders = array();
	protected $booted = false;

	function __construct(Request $request = null)
	{
		// If a request was passed to the constructor, we use it.
		// Otherwise we create a new one from globals.
		$this['request'] = ($request)
			? $request
			: Request::createFromGlobals();

		// Core services. (A lot of Illuminate components depend on these.)
		$this->register(new EventServiceProvider($this));
		$this->register(new ExceptionServiceProvider($this));
	}

	public function register(ServiceProvider $provider)
	{
		$provider->register();
		$this->serviceProviders[] = $provider;
	}

	public function bindFrameworkPaths(array $paths)
	{
		$this->instance('path',			$paths['app']);
		$this->instance('path.base',	$paths['base']);
		$this->instance('path.public',	$paths['public']);
	}

	public function run()
	{
		// Dispatch request and prepare the response.
		$response = $this->prepareResponse(
			$this->dispatch($this['request']),
			$this['request']
		);

		// Fire application before event.
		$this['events']->fire('application.before', array($response));

		$response->send();

		// Fire application after event.
		$this['events']->fire('application.before', array($response));
	}

	public function boot()
	{
		// Do not boot again if Application already has been booted.
		if ($this->booted) {
			return;
		}

		// Boot all service providers.
		foreach ($this->serviceProviders as $provider) {
			$provider->boot();
		}

		// Booting finished, this can not occur again during this session.
		$this->booted = true;
	}

	public function dispatch(Request $request)
	{
		// Prepare request and dispatch request from the router.
		return $this['router']->dispatch($this->prepareRequest($this['request']));
	}

	public function prepareRequest(Request $request)
	{
		// If session is available, set session store on request.
		if (isset($this['session'])) {
			$request->setSessionStore($this['session']);
		}

		return $request;
	}

	public function prepareResponse($response, Request $request)
	{
		if (!$response instanceof Response) {
			$response = new Response($response);
		}

		return $response->prepare($request);
	}

	public function before($callback)
	{
		$this['events']->listen('application.before', $callback);
	}

	public function after($callback)
	{
		$this['events']->listen('application.after', $callback);
	}

	public function missing($callback)
	{
		$this->error(function(NotFoundHttpException $e)
		{
			return call_user_func($callback, $e);
		});
	}

	public function error(Closure $callback)
	{
		$this['exception']->error($callback);
	}
}