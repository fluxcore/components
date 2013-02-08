<?php

namespace FluxCore\Routing\Route;

use FluxCore\Routing\Route\RouteKeyable;

class RouteCollection implements \IteratorAggregate
{
	protected $buffer = array();

	public function add(RouteKeyable $route)
	{
		return ($this->buffer[$route->getKey()] = $route);
	}

	public function get(RouteKeyable $route)
	{
		return ($this->has($route))
			? $this->buffer[$route->getKey()]
			: null;
	}

	public function has(RouteKeyable $route)
	{
		return isset($this->buffer[$route->getKey()]);
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->buffer);
	}
}