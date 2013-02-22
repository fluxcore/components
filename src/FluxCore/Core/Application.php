<?php

namespace FluxCore\Core;

use Illuminate\Events\EventServiceProvider;
use Illuminate\Exception\ExceptionServiceProvider;
use Illuminate\Foundation\Application as IlluminateApplication;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application extends IlluminateApplication
{
	function __construct(Request $request = null)
	{
		$this['request'] = ($request)
			? $request
			: Request::createFromGlobals();

		$this->register(new ExceptionServiceProvider($this));
		$this->register(new EventServiceProvider($this));
	}

	public function run()
	{
		$response = $this->dispatch($this['request']);
		$this['events']->fire('application.finish', $response);
	}

	public function before($callback)
	{
		$this['events']->listen('application.before', $callback);
	}

	public function after($callback)
	{
		$this['events']->listen('application.after', $callback);
	}

	public function close($callback)
	{
		$this['events']->listen('application.close', $callback);
	}

	public function finish($callback)
	{
		$this['events']->listen('application.finish', $callback);
	}
}