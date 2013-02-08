<?php

use FluxCore\Routing\Route\RouteIdentifier;

class RouteIdentifiertest extends PHPUnit_Framework_TestCase
{
	public function testNotDispatchableException()
	{
		try {
			$routeIdentifier = new RouteIdentifier('', '');
			$routeIdentifier->dispatch();
		} catch(RuntimeException $e) {
			$this->assertEquals(
				'RouteIdentifier is not dispatchable.',
				$e->getMessage()
			);

			return;
		}

		$this->fail('Expected RuntimeException was not raised.');
	}
}