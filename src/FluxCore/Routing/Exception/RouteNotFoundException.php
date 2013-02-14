<?php

namespace FluxCore\Routing\Exception;

use FluxCore\Routing\Route\RouteIdentifier;

class RouteNotFoundException extends \Exception
{
	protected $identifier;

	function __construct($message, RouteIdentifier $identifier)
	{
		parent::__construct($message);
		$this->identifier = $identifier;
	}

	public function getRouteIdentifier()
	{
		return $this->identifier;
	}
}