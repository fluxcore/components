<?php

namespace FluxCore\Core;

use Closure;
use FluxCore\Config\ConfigServiceProvider;
use Illuminate\Container\Container;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Exception\ExceptionServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Application extends Container
{
	protected $initialized = false;

	function __construct(Request $request = null, ServiceManager $services = null)
	{
		// If a request was passed to the constructor, we use it.
		// Otherwise we create a new one from globals.
		$this['request'] = ($request)
			? $request
			: Request::createFromGlobals();

		// If a specific service manager was passed, we use it.
		// Otherwise we create a new one.
		$this['services'] = ($services)
			? $services
			: new ServiceManager();
	}

	public function initialize(Closure $callback)
	{
		// Do not initialize if application already has been initialized.
		if ($this->initialized) {
			return;
		}

		// Configuration service.
	//	$this['services']->register(new ConfigServiceProvider($this));

		// illuminate/filesystem
	//	$this['services']->register(new FilesystemServiceProvider($this));

		// illuminate/events
	//	$this['services']->register(new EventServiceProvider($this));

		// illuminate/exception
	//	$this['services']->register(new ExceptionServiceProvider($this));

		// Invoke callback with a reference to this class.
		call_user_func($callback, $this);

		// Application is now initialized.
		$this->initialized = true;
	}

	public function hasInitialized()
	{
		return $this->initialized;
	}

	public function event($name, $callback)
	{
		if (!isset($this['events'])) {
			throw new \RuntimeException(
				'Unable to bind application event as '.
				'$this[\'events\'] has not been defined'
			);
		}

		$this['events']->listen("app.$name", $callback);
	}

	public function run()
	{
		if (!isset($this['router'])) {
			throw new \RuntimeException(
				'Unable to run application as '.
				'$this[\'router\'] has not been defined'
			);
		}

		$request = $this->prepareRequest($this['request']);
		$response = $this['router']->dispatch($request);
		$response = $this->prepareResponse($response, $request);

		$response->send();
	}

	public function prepareRequest(Request $request)
	{
		// TODO

		return $request;
	}

	public function prepareResponse($response, Request $request)
	{
		if (!$response instanceof Response) {
			$response = new Response($response);
		}

		return $response->prepare($request);
	}

	public function bindFrameworkPaths(array $paths)
	{
		foreach ($paths as $abstract => $path) {
			$this["path.$abstract"] = $path;
		}
	}

	public function getBootstrapFile()
	{
		// Maybe but probably not..
		// return __DIR__.'/start.php';
		
		// return $this['path'].'/start.php';
	}
}