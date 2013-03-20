<?php

namespace FluxCore\Routing\Route;

use Closure;

/**
 * Route class.
 */
class Route extends RouteKeyable
{
	/**
	 * The route handler.
	 * 
	 * @var Closure
	 */
	protected $handler;

	/**
	 * The route arguments.
	 * 
	 * @var array
	 */
	protected $arguments = array();

	/**
	 * Creates a new route instance.
	 * 
	 * @param string $pattern
	 * @param string $method
	 * @param Closure $handler
	 */
	function __construct($pattern, $method, Closure $handler)
	{
		parent::__construct($pattern, $method);
		$this->setHandler(($handler != null) ? $handler : function() { });
	}

	/**
	 * Get route handler.
	 * 
	 * @return Closure
	 */
	public function getHandler()
	{
		return $this->handler;
	}

	/**
	 * Set route handler.
	 * 
	 * @param Closure $handler
	 */
	public function setHandler(Closure $handler)
	{
		return ($this->handler = $handler);
	}

	/**
	 * Get route arguments.
	 * 
	 * @return array
	 */
	public function getArguments()
	{
		return $this->arguments;
	}

	/**
	 * Set route arguments.
	 * 
	 * @param array $arguments
	 */
	public function setArguments(array $arguments)
	{
		return ($this->arguments = $arguments);
	}

	/**
	 * Dispatch route.
	 * 
	 * @param array $arguments
	 * @return mixed
	 */
	public function dispatch($arguments = null)
	{
		return closure_proxy(
			$this->handler,
			(is_array($arguments)) ? $arguments : $this->arguments
		);
	}
}