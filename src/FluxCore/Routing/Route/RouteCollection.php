<?php

namespace FluxCore\Routing\Route;

use FluxCore\Routing\Route\RouteKeyable;

/**
 * Route collection class.
 */
class RouteCollection implements \IteratorAggregate
{
	/**
	 * The route buffer.
	 * 
	 * @var array
	 */
	protected $buffer = array();

	/**
	 * Add route to collection.
	 * 
	 * @param FluxCore::Routing::Route::RouteKeyable $route
	 */
	public function add(RouteKeyable $route)
	{
		return ($this->buffer[$route->getKey()] = $route);
	}

	/**
	 * Get route from collection.
	 * 
	 * @param FluxCore::Routing::Route::RouteKeyable $route
	 * @return FluxCore::Routing::Route::Route
	 */
	public function get(RouteKeyable $route)
	{
		return ($this->has($route))
			? $this->buffer[$route->getKey()]
			: null;
	}

	/**
	 * Does route exist in collection?
	 * 
	 * @param FluxCore::Routing::Route::RouteKeyable $route
	 * @return boolean
	 */
	public function has(RouteKeyable $route)
	{
		return isset($this->buffer[$route->getKey()]);
	}

	/**
	 * IteratorAggregate getIterator implementation.
	 * 
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->buffer);
	}
}