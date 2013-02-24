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
	protected $initialize = false;
	protected $run = false;

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

	public function initialize($callback)
	{
		// Do not initialize if application already has been initialized.
	//	if ($this->initialize) {
	//		return;
	//	}

		// Invoke callback with a reference to this class.
		call_user_func($callback, $this);

		// Application is now initialized.
		$this->initialize = true;
	}

	public function hasInitialized()
	{
		return $this->initialize;
	}

	public function run($callback)
	{
		// Do not run if application already has been run.
	//	if ($this->run) {
	//		return;
	//	}

		// Invoke callback with a reference to this class and the request.
		call_user_func($callback, $this, $this['request']);

		// Application has been run.
		$this->run = true;
	}

	public function hasRun()
	{
		return $this->run;
	}

	public function bindPaths(array $paths)
	{
		foreach ($paths as $abstract => $path) {
			$this["path.$abstract"] = $path;
		}
	}
}