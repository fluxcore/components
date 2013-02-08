<?php

namespace FluxCore\Routing\Route;

abstract class RouteKeyable
{
	protected $pattern;
	protected $method;

	function __construct($pattern, $method)
	{
		$this->setPattern($pattern);
		$this->setMethod($method);
	}

	public abstract function dispatch();

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
}