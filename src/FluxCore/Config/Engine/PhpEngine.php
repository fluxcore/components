<?php

namespace FluxCore\Config\Engine;

use FluxCore\Config\Configuration;

class PhpEngine implements EngineInterface
{
	public function parse($file)
	{
		return new Configuration(include $file);
	}
}