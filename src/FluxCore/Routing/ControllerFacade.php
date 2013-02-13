<?php

namespace FluxCore\Routing;

use FluxCore\Core\Facade;

class ControllerFacade extends Facade
{
	public static function make($name)
	{
		return self::$app->make("{$name}Controller");
	}
}