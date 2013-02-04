<?php

namespace FluxCore\Core;

class AliasLoader
{
    private $aliasMap = array();

    public function getAliasMap()
    {
        return $this->aliasMap;
    }

    /**
     * @param array $aliasMap Class to filename map
     */
    public function addAliasMap(array $aliasMap)
    {
        if ($this->aliasMap) {
            $this->aliasMap = array_merge($this->aliasMap, $aliasMap);
        } else {
            $this->aliasMap = $aliasMap;
        }
    }

	/**
	 * Registers this instance as an autoloader.
	 *
	 * @param bool $prepend Whether to prepend the autoloader or not
	 */
	public function register($prepend = true)
	{
		spl_autoload_register(array($this, 'loadClass'), true, $prepend);
	}

	/**
	 * Unregisters this instance as an autoloader.
	 */
	public function unregister()
	{
		spl_autoload_unregister(array($this, 'loadClass'));
	}

	/**
	 * Loads the given class or interface.
	 *
	 * @param  string	$class The name of the class
	 * @return bool|null True, if loaded
	 */
	public function loadClass($class)
	{
		if (isset($this->aliasMap[$class])) {
			class_exists($this->aliasMap[$class]);
			class_alias($this->aliasMap[$class], $class);
		}
	}
}