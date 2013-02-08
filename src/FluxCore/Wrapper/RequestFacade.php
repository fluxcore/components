<?php

namespace FluxCore\Wrapper;

use FluxCore\Core\Facade;

class RequestFacade extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'request';
	}
}