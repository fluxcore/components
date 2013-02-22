<?php

namespace FluxCore\Facade;

class Route extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'router';
	}
}