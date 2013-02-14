<?php

namespace FluxCore\Routing\Route;

class RouteIdentifier extends RouteKeyable
{
	function __toString()
	{
		return $this->getMethod().':'.$this->getPattern();
	}

	public function dispatch()
	{
		throw new \RuntimeException(
			'RouteIdentifier is not dispatchable.'
		);
	}
}