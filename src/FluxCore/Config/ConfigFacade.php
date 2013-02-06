<?php

namespace FluxCore\Config;

use FluxCore\Core\Facade;

class ConfigFacade extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'config';
	}
}