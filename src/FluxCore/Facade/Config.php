<?php

namespace FluxCore\Facade;

class Config extends Illuminate\Support\Facades\Config
{
	public static function getFacadeAccessor()
	{
		return 'config';
	}
}