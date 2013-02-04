<?php

namespace FluxCore\Core;

class Facade
{
	protected static $app;
	protected static $resolvedInstances = array();

	public static function __callStatic($name, $args)
	{
		return method_proxy(self::getFacadeObject(), $name, $args);
	}

	public static function setFacadeApplication(Application $app)
	{
		return (self::$app = $app);
	}

	public static function getFacadeApplication()
	{
		return self::$app;
	}

	public static function clearFacade()
	{
		self::$app = null;
		self::$resolvedInstances = array();
	}

	public static function getFacadeObject()
	{
		$accessor = static::getFacadeAccessor();

		if(isset(self::$resolvedInstances[$accessor])) {
			return self::$resolvedInstances[$accessor];
		}

		return (self::$resolvedInstances[$accessor] = self::$app[$accessor]);
	}

	public static function getFacadeAccessor()
	{
		$facade = get_called_class();
		throw new \RuntimeException(
			"Facade '$facade' does not implement getFacadeAccessor()."
		);
	}
}