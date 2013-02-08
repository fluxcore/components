<?php

namespace FluxCore\Routing\Route;

class Route extends RouteKeyable
{
	protected $handler;
	protected $arguments = array();

	function __construct($pattern, $method, \Closure $handler)
	{
		parent::__construct($pattern, $method);
		$this->setHandler(($handler != null) ? $handler : function() { });
	}

	public function getHandler()
	{
		return $this->handler;
	}

	public function setHandler(\Closure $handler)
	{
		return ($this->handler = $handler);
	}

	public function getArguments()
	{
		return $this->arguments;
	}

	public function setArguments(array $arguments)
	{
		return ($this->arguments = $arguments);
	}

	public function dispatch($arguments = null)
	{
		return closure_proxy(
			$this->handler,
			(is_array($arguments)) ? $arguments : $this->arguments
		);
	}
}