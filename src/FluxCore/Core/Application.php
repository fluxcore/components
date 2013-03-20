<?php

namespace FluxCore\Core;

use Closure;
use FluxCore\Config\ConfigServiceProvider;
use Illuminate\Container\Container;
use Symfony\Component\HttpFoundation\Request;

/**
 * Application class.
 */
class Application extends Container
{
	/**
	 * The application fallback handler.
	 * 
	 * @var object
	 */
	protected $fallbackHandler;

	/**
	 * Is the application initialized?
	 * 
	 * @var boolean
	 */
	protected $initialize = false;

	/**
	 * Has the application been ran yet?
	 * 
	 * @var boolean
	 */
	protected $run = false;

	/**
	 * Creates a new Application instance.
	 * 
	 * @param Symfony::Component::HttpFoundation::Request $request
	 * @param FluxCore::Core::ServiceManager $services
	 */
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

	/**
	 * Application method call fallback.
	 *
	 * Invokes the fallback handler.
	 * 
	 * @param string $name
	 * @param array $args
	 * @return mixed
	 */
	function __call($name, $args)
	{
		if (is_null($this->fallbackHandler)) {
			throw new \RuntimeException(
				'Can\'t perform fallback operation as no fallback '.
				'handler has been assigned.'
			);
		}

		return method_proxy($this->fallbackHandler, $name, $args);
	}

	/**
	 * Get the application fallback handler.
	 * 
	 * @return object
	 */
	public function getFallbackHandler()
	{
		return $this->fallbackHandler;
	}

	/**
	 * Set the application fallback handler.
	 * 
	 * @param object $fallbackHandler
	 */
	public function setFallbackHandler($fallbackHandler)
	{
		$this->fallbackHandler = $fallbackHandler;
	}

	/**
	 * Initialize the application.
	 * 
	 * @param callable $callback
	 */
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

	/**
	 * Has the application been initialized yet?
	 * 
	 * @return boolean
	 */
	public function hasInitialized()
	{
		return $this->initialize;
	}

	/**
	 * Run the application.
	 * 
	 * @param callable $callback
	 */
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

	/**
	 * Has the application been ran yet?
	 * 
	 * @return boolean
	 */
	public function hasRun()
	{
		return $this->run;
	}

	/**
	 * Bind paths to the application.
	 * 
	 * @param array $paths 
	 */
	public function bindPaths(array $paths)
	{
		foreach ($paths as $abstract => $path) {
			if ($abstract == 'app') {
				$this['path'] = $path;
			} else {
				$this["path.$abstract"] = $path;
			}
		}
	}
}