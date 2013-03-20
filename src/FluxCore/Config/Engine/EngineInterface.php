<?php

namespace FluxCore\Config\Engine;

/**
 * Describes a configuration engine interface.
 */
interface EngineInterface
{
	/**
	 * Parses the specified file into a readable
	 * configuration object.
	 * 
	 * @param string $file
	 * @return FluxCore::Config::Configuration
	 */
	public function parse($file);
}