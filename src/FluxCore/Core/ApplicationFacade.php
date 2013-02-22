<?php

namespace FluxCore\Core;

class ApplicationFacade extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'app';
	}
}