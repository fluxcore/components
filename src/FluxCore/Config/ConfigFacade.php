<?php

namespace FluxCore\Config\ConfigFacade;

use FluxCore\Core\Facade;

class ConfigFacade extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'config';
	}
}