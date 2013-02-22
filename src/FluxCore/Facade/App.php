<?php

namespace FluxCore\Core;

class App extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'app';
	}
}