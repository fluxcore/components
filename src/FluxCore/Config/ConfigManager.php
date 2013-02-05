<?php

namespace FluxCore\Config;

use FluxCore\Config\EngineResolver;
use FluxCore\IO\FileFinder;

class ConfigManager
{
	protected $resolver;
	protected $fileFinder;
	protected $configs = array();

	function __construct(EngineResolver $resolver, FileFinder $fileFinder)
	{
		$this->resolver = $resolver;
		$this->fileFinder = $fileFinder;
	}

	public function getResolver()
	{
		return $this->resolver;
	}

	public function getFileFinder()
	{
		return $this->fileFinder;
	}

	public function make($abstract)
	{
		if(isset($this->configs[$abstract])) {
			return $this->configs[$abstract];
		}

		$files = $this->fileFinder->find($abstract);
		if(empty($files)) {
			throw new \RuntimeException(
				"The configuration for '$abstract' does not exist."
			);
		}

		return ($this->configs[$abstract] = $this->resolver->resolve($abstract));
	}
}