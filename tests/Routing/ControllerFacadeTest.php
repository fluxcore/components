<?php

use FluxCore\Core\Application;
use FluxCore\Core\Facade;
use FluxCore\Routing\ControllerFacade;

class ControllerFacadeTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		Facade::clearFacade();
		Facade::setFacadeApplication(new Application());
	}

	public function testMake()
	{
		$this->assertInstanceOf(
			'StubController',
			ControllerFacade::make('Stub')
		);

		$this->assertInstanceOf(
			'StubController',
			ControllerFacade::make('stub')
		);

		$this->assertEquals(
			'Hello World',
			ControllerFacade::make('stub')->index()
		);
	}
}

class StubController
{
	public function index() { return 'Hello World'; }
}