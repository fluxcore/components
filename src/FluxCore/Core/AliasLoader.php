<?php

namespace FluxCore\Core;

class AliasLoader {

	/**
	 * The registered aliases.
	 *
	 * @var array
	 */
	protected static $aliases = array();

	/**
	 * Indicates if a AliasLoader has been registered.
	 *
	 * @var bool
	 */
	protected static $registered = false;

	/**
	 * Load the given class from alias.
	 *
	 * @param  string  $alias
	 * @return void
	 */
	public static function load($alias)
	{
		$alias = static::normalizeAlias($alias);

		if (isset(static::$aliases[$alias])) {
			class_alias(static::$aliases[$alias], $alias);
		}

		return false;
	}

	/**
	 * Get a normalized alias.
	 *
	 * @param  string  $alias
	 * @return string
	 */
	public static function normalizeAlias($alias)
	{
		if ($alias[0] == '\\') {
			$alias = substr($alias, 1);
		}

		return $alias;
	}

	/**
	 * Register the given alias loader on the auto-loader stack.
	 *
	 * @return void
	 */
	public static function register()
	{
		if (!static::$registered) {
			spl_autoload_register(array('\FluxCore\Core\AliasLoader', 'load'), true, true);

			static::$registered = true;
		}
	}

	/**
	 * Gets all the aliases registered with the loader.
	 *
	 * @return array
	 */
	public static function getAliases()
	{
		return static::$aliases;
	}

	public static function addAliases(array $aliases)
	{
		foreach ($aliases as $alias => $class) {
			static::$aliases[static::normalizeAlias($alias)] = $class;
		}
	}

}