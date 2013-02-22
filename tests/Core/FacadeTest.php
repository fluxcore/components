<?php

use FluxCore\Core\Application;
use FluxCore\Core\Facade;

class FacadeTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->app = new Application;
		Facade::clearFacade(); // I hate unit-testing static things.
		Facade::setFacadeApplication($this->app);
	}

	public function testSetGetFacadeApplication()
	{
		$this->assertInstanceOf(
			'FluxCore\Core\Application',
			Facade::getFacadeApplication()
		);
	}

	public function testGetFacadeObject()
	{
		$this->app['test'] = array('hello', 'world');
		$this->assertEquals(
			array('hello', 'world'),
			FacadeStub::getFacadeObject()
		);
	}

	public function testGetFacadeAccessorNotImplemented()
	{
		try {
			FacadeStubNotImplemented::getFacadeAccessor();
		} catch(RuntimeException $e) {
			$this->assertEquals(
				"Facade 'FacadeStubNotImplemented' does not implement getFacadeAccessor().",
				$e->getMessage()
			);

			return;
		}

		$this->fail('Expected RuntimeException was not raised.');
	}

	public function testCallStaticProxy()
	{
		$this->app['test'] = new ClassStub();
		$this->assertEquals(
			'world',
			FacadeStub::hello('world')
		);
	}
}

class FacadeStub extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'test';
	}
}

class FacadeStubNotImplemented extends Facade {}

class ClassStub
{
	public function hello($world)
	{
		return $world;
	}
}