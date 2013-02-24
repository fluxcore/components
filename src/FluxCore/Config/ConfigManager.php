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

	public function get($abstract, $default = null)
	{
		// Split last key off of abstract and put it in a separate
		// value and implode abstract again without key part.
		$split = explode('.', $abstract);
		$key = array_pop($split);
		$abstract = implode('.', $split);

		if ($abstract == '') {
			$abstract = $key;
			$key = null;
		}

		// If configuration isn't buffered, gather files and resolve
		// first found file if there is one.
		if(!isset($this->configs[$abstract])) {
			$files = $this->fileFinder->find($abstract);
			if(!empty($files)) {
				$this->configs[$abstract] = $this->resolver->resolve($files[0]);
			}
		}

		$value = (isset($this->configs[$abstract]))
			? $this->configs[$abstract]
			: null;

		if ($key != null && $value != null) {
			$value = (isset($value[$key]))
				? $value[$key]
				: null;
		}

		// Return the configuration value if it is set, otherwise
		// return default.
		return ($value !== null) ? $value : $default;
	}

	public function offsetGet($offset)
	{
		return $this->get($offset);
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
		//
	}
}