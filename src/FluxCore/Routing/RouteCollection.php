<?php

namespace FluxCore\Routing;

class RouteCollection implements \IteratorAggregate
{
	protected $buffer = array();

	public function add(Route $route)
	{
		return ($this->buffer[$route->getKey()] = $route);
	}

	public function get(Route $route)
	{
		return ($this->has($route))
			? $this->buffer[$route->getKey()]
			: null;
	}

	public function has(Route $route)
	{
		return isset($this->buffer[$route->getKey()]);
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->buffer);
	}
}