<?php

namespace FluxCore\Facade;

class Request extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'request';
	}
}