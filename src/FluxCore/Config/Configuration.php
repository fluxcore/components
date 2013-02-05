<?php

namespace FluxCore\Config;

/**
 * Configuration data abstraction class.
 */
class Configuration implements \ArrayAccess
{
	protected $data;

	function __construct($data = array())
	{
		$this->data = $data;
	}

	function __get($name)
	{
		return (isset($this->data[$name]))
			? $this->data[$name]
			: null;
	}

	function __set($name, $value)
	{
		//
	}

	public function offsetExists($offset)
	{
		return isset($this->data[$offset]);
	}

	public function offsetGet($offset)
	{
		return ($this->offsetExists($offset))
			? $this->data[$offset]
			: null;
	}

	public function offsetSet($offset, $value)
	{
		//
	}

	public function offsetUnset($offset)
	{
		//
	}
}