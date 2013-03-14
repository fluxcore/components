<?php

namespace FluxCore\Config;

/**
 * Configuration data abstraction class.
 */
class Configuration implements \ArrayAccess
{
	/**
	 * The configuration data values.
	 * 
	 * @var array
	 */
	protected $data;

	/**
	 * Creates a new configuration abstraction
	 * with the supplied data.
	 * 
	 * @param array $data
	 */
	function __construct($data = array())
	{
		$this->data = $data;
	}

	/**
	 * Get value.
	 * 
	 * @param string $name
	 * @return mixed The configuration value or null if it does not exist.
	 */
	function __get($name)
	{
		return (isset($this->data[$name]))
			? $this->data[$name]
			: null;
	}

	/**
	 * Set value.
	 * 
	 * @param string $name
	 * @param mixed $value
	 */
	function __set($name, $value)
	{
		$this->data[$name] = $value;
	}

	/**
	 * Get array representation of the configuration values.
	 * 
	 * @return array
	 */
	public function toArray()
	{
		return $this->data;
	}

	/**
	 * ArrayAccess offsetExists implementation.
	 * 
	 * @param string $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return isset($this->data[$offset]);
	}

	/**
	 * ArrayAccess offsetGet implementation.
	 * 
	 * @param string $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return ($this->offsetExists($offset))
			? $this->data[$offset]
			: null;
	}

	/**
	 * ArrayAccess offsetSet implementation.
	 * 
	 * @param string $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value)
	{
		$this->data[$offset] = $value;
	}

	/**
	 * ArrayAccess offsetUnset implementation.
	 * 
	 * @param string $offset
	 */
	public function offsetUnset($offset)
	{
		unset($this->data[$offset]);
	}
}