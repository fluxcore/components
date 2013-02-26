<?php

namespace FluxCore\Core;

class FallbackHandler
{
	protected $app;
	protected $missing = array();

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

	public function addMissingDependency($name)
	{
		$this->missing[] = $name;
	}

	public function checkDependencies()
	{
		// Dependency check is not implemented by child.
	}
}