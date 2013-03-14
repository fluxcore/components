<?php

namespace FluxCore\Config;

use FluxCore\Config\Engine\EngineInterface;

/**
 * Configuration engine resolver class.
 */
class EngineResolver
{
	/**
	 * Resolve configuration file.
	 *
	 * Parses the specified configuration file
	 * using the engine that has been assigned to
	 * the same file-extension.
	 * 
	 * @param string $file
	 * @return FluxCore\Config\Configuration
	 */
	public function resolve($file)
	{
		$extension = file_extension($file);
		if(!isset($this->engines[$extension])) {
			throw new \RuntimeException(
				"There's no engine assigned for the '$extension' file-format."
			);
		}

		return $this->engines[$extension]->parse($file);
	}

	/**
	 * Register configuration engine.
	 *
	 * Registers a configuration engine to parse files
	 * with the specified file-extension.
	 * 
	 * @param string $extension
	 * @param FluxCore\Config\EngineInterface $engine
	 * @return FluxCore\Config\EngineInterface
	 */
	public function register($extension, EngineInterface $engine)
	{
		return ($this->engines[$extension] = $engine);
	}
}