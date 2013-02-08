<?php

namespace FluxCore\Routing\Route;

class RouteIdentifier extends RouteKeyable
{
	public function dispatch()
	{
		throw new \RuntimeException(
			'RouteIdentifier is not dispatchable.'
		);
	}
}