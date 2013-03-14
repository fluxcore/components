<?php

namespace FluxCore\Routing\Route;

/**
 * Route identifier class.
 */
class RouteIdentifier extends RouteKeyable
{
	/**
	 * Class to string.
	 * 
	 * @return string
	 */
	function __toString()
	{
		return $this->getMethod().':'.$this->getPattern();
	}

	/**
	 * Dispatch route.
	 */
	public function dispatch()
	{
		throw new \RuntimeException(
			'RouteIdentifier is not dispatchable.'
		);
	}
}