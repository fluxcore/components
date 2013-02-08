<?php

namespace FluxCore\Routing;

use FluxCore\Core\Facade;

class RoutingFacade extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'router';
	}
}