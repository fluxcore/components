<?php

namespace FluxCore\Core;

/**
 * Application fallback handler base class.
 */
class FallbackHandler
{
	/**
	 * The application.
	 * 
	 * @var FluxCore::Core::Application
	 */
	protected $app;

	/**
	 * The missing dependencies.
	 * 
	 * @var array
	 */
	protected $missing = array();

	/**
	 * Creates a new fallback handler instance.
	 * 
	 * @param array|FluxCore::Core::Application $app
	 */
	function __construct($app = null)
	{
		$this->app = $app;

		$this->checkDependencies();
		if (!empty($this->missing)) {
			throw new \RuntimeException(
				'FallbackHandler failed dependency check, '.
				'missing dependencies: '.implode(', ', $this->missing)
			);
		}
	}

	/**
	 * Add missing dependency.
	 * 
	 * @param string $name
	 */
	public function missingDependency($name)
	{
		$this->missing[] = $name;
	}

	/**
	 * Check dependencies.
	 */
	public function checkDependencies()
	{
		// Dependency check is not implemented by child.
	}
}