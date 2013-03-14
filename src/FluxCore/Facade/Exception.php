<?php

namespace FluxCore\Facade;

use FluxCore\Core\Facade;

/**
 * Exception facade.
 */
class Exception extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'exception';
	}
}