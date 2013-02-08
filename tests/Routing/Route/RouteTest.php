<?php

use FluxCore\Routing\Route\Route;

class RouteTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->route = new Route('', '', function($name)
		{
			return "Hello $name.";
		});
	}

	public function testArgumentsSetAndGet()
	{
		$this->route->setArguments(array('hi', 'all'));
		$this->assertEquals(
			array('hi', 'all'),
			$this->route->getArguments()
		);
	}

	public function testHandlerDispatch()
	{
		$this->assertEquals(
			'Hello John.',
			$this->route->dispatch(array('John'))
		);

		$this->route->setArguments(array('all'));
		$this->assertEquals('Hello all.', $this->route->dispatch());
	}
}