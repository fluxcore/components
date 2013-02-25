<?php

namespace FluxCore\Facade;

use FluxCore\Core\Facade;

class Exception extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'exception';
	}
}