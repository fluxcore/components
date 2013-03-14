<?php

namespace FluxCore\Routing\Route;

/**
 * Keyable route base class.
 */
abstract class RouteKeyable
{
	/**
	 * The route pattern.
	 * 
	 * @var string
	 */
	protected $pattern;

	/**
	 * The route method.
	 * 
	 * @var string
	 */
	protected $method;

	/**
	 * Creates a new keyable route instance.
	 * 
	 * @param string $pattern
	 * @param string $method
	 */
	function __construct($pattern, $method)
	{
		$this->setPattern($pattern);
		$this->setMethod($method);
	}

	/**
	 * Dispatch route.
	 * 
	 * @return mixed
	 */
	public abstract function dispatch();

	/**
	 * Get route key.
	 * 
	 * @return string
	 */
	public function getKey()
	{
		return md5("{$this->method}:{$this->pattern}");
	}

	/**
	 * Get route pattern.
	 * 
	 * @return string
	 */
	public function getPattern()
	{
		return $this->pattern;
	}

	/**
	 * Set route pattern.
	 * 
	 * @param string $pattern
	 */
	public function setPattern($pattern)
	{
		$pattern = trim($pattern, '/');
		$pattern = ($pattern != '') ? $pattern : '/';

		return ($this->pattern = $pattern);
	}

	/**
	 * Get route method.
	 * 
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * Set route method.
	 * 
	 * @param string $method
	 */
	public function setMethod($method)
	{
		$method = strtoupper($method);

		return ($this->method = $method);
	}
}