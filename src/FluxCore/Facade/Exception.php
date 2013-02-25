<?php

namespace FluxCore\Facade;

class Exception extends FluxCore\Core\Facade
{
	public static function getFacadeAccessor()
	{
		return 'exception';
	}
}