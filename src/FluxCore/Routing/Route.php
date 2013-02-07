<?php

namespace FluxCore\Routing;

class Route
{
	protected $pattern;
	protected $method;
	protected $handler;

	function __construct($pattern, $method, \Closure $handler = null)
	{
		$this->setPattern($pattern);
		$this->setMethod($method);
		$this->setHandler(($handler != null) ? $handler : function() { });
	}

	public function getKey()
	{
		return md5("{$this->method}:{$this->pattern}");
	}

	public function getPattern()
	{
		return $this->pattern;
	}

	public function setPattern($pattern)
	{
		$pattern = trim($pattern, '/');
		$pattern = ($pattern != '') ? $pattern : '/';

		return ($this->pattern = $pattern);
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function setMethod($method)
	{
		$method = strtoupper($method);

		return ($this->method = $method);
	}

	public function getHandler()
	{
		return $this->handler;
	}

	public function setHandler(\Closure $handler)
	{
		return ($this->handler = $handler);
	}

	public function dispatch($arguments = array())
	{
		return closure_proxy($this->handler, $arguments);
	}
}