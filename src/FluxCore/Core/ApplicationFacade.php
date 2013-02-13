<?php

namespace FluxCore\Core;

class ApplicationFacade extends Facade
{
	public function getFacadeAccessor()
	{
		return 'app';
	}
}