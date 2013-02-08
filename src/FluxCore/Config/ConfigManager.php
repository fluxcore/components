<?php

namespace FluxCore\Config;

use FluxCore\Config\EngineResolver;
use FluxCore\IO\FileFinder;

class ConfigManager implements \ArrayAccess
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

		return ($this->configs[$abstract] = $this->resolver->resolve($files[0]));
	}

	public function offsetGet($offset)
	{
		$split = explode('.', $offset);
		$key = array_pop($split);

		$config = $this->make(implode('.', $split));
		return $config[$key];
	}

	public function offsetSet($offset, $value)
	{
		//
	}

	public function offsetUnset($offset)
	{
		//
	}

	public function offsetExists($offset)
	{
		try {
			$this->make($offset);
		} catch(\RuntimeException $e) {
			return false;
		}

		return true;
	}
}