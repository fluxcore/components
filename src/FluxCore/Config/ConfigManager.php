<?php

namespace FluxCore\Config;

use FluxCore\Config\EngineResolver;
use FluxCore\IO\FileFinder;

/**
 * Configuration manager class.
 */
class ConfigManager implements \ArrayAccess
{
	/**
	 * The configuration engine resolver.
	 * 
	 * @var FluxCore::Config::EngineResolver
	 */
	protected $resolver;

	/**
	 * The configuration file finder.
	 * 
	 * @var FluxCore::IO::FileFinder
	 */
	protected $fileFinder;

	/**
	 * The resolved configuration buffer.
	 * 
	 * @var array
	 */
	protected $configs = array();

	/**
	 * Creates a new configuration manager instance.
	 * 
	 * @param FluxCore::Config::EngineResolver $resolver
	 * @param FluxCore::IO::FileFinder $fileFinder
	 */
	function __construct(EngineResolver $resolver, FileFinder $fileFinder)
	{
		$this->resolver = $resolver;
		$this->fileFinder = $fileFinder;
	}

	/**
	 * Get the configuration engine resolver.
	 * 
	 * @return FluxCore::Config::EngineResolver
	 */
	public function getResolver()
	{
		return $this->resolver;
	}

	/**
	 * Get the configuration file finder.
	 * 
	 * @return FluxCore::IO::FileFinder
	 */
	public function getFileFinder()
	{
		return $this->fileFinder;
	}

	/**
	 * Get configuration value(s).
	 * 
	 * @param string $abstract
	 * @param mixed $default
	 * @return mixed The configuration/value that was requested.
	 */
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

	/**
	 * Set configuration value.
	 * 
	 * @param string $abstract
	 * @param mixed $value
	 */
	public function set($abstract, $value)
	{
		// Split last key off of abstract and put it in a separate
		// value and implode abstract again without key part.
		$split = explode('.', $abstract);
		$key = array_pop($split);
		$abstract = implode('.', $split);

		// If no key was passed, return.
		if ($abstract == '') {
			return;
		}

		// Get config and return if it doesn't exist.
		$config = $this->get($abstract);
		if (!$config instanceof Configuration) {
			return;
		}

		// If passed value is null, unset the configuration value.
		if ($value === null) {
			unset($config[$key]);

			return;
		}

		// Assign configuration value.
		$config[$key] = $value;
	}

	/**
	 * ArrayAccess offsetGet implementation.
	 *
	 * This method wraps the configuration manager
	 * get method.
	 * 
	 * @param string $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->get($offset);
	}

	/**
	 * ArrayAccess offsetSet implementation.
	 *
	 * This method wraps the configuration manager
	 * set method.
	 * 
	 * @param string $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value)
	{
		$this->set($offset, $value);
	}

	/**
	 * ArrayAccess offsetUnset implementation.
	 *
	 * This method wraps the configuration manager
	 * set method and sets null.
	 * 
	 * @param string $offset
	 */
	public function offsetUnset($offset)
	{
		$this->set($offset, null);
	}

	/**
	 * ArrayAccess offsetExists implementation.
	 *
	 * This method wraps the configuration manager
	 * get method and checks if returned value is null.
	 * 
	 * @param string $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return $this->get($offset) !== null;
	}
}