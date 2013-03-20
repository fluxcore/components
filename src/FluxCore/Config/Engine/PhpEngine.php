<?php

namespace FluxCore\Config\Engine;

use FluxCore\Config\Configuration;

/**
 * PHP configuration engine class.
 *
 * PHP file parser engine for configuration.
 */
class PhpEngine implements EngineInterface
{
	/**
	 * Parses the specified PHP file into
	 * a readable configuration object.
	 * 
	 * @param string $file
	 * @return FluxCore::Config::Configuration
	 */
	public function parse($file)
	{
		return new Configuration(include $file);
	}
}