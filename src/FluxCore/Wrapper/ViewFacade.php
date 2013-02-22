<?php

namespace FluxCore\Wrapper;

use FluxCore\Core\Facade;

class ViewFacade extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'view';
	}
}