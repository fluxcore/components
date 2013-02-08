<?php

use FluxCore\Routing\Route\RouteKeyable;

class RouteKeyableTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->route = new RouteStub('', '');
	}

	public function testPattern()
	{
		$this->route->setPattern('/');
		$this->assertEquals('/', $this->route->getPattern());

		$this->route->setPattern('');
		$this->assertEquals('/', $this->route->getPattern());

		$this->route->setPattern('/test/hello/');
		$this->assertEquals('test/hello', $this->route->getPattern());

		$this->route->setPattern('/test/');
		$this->assertEquals('test', $this->route->getPattern());
	}

	public function testMethod()
	{
		$this->route->setMethod('get');
		$this->assertEquals('GET', $this->route->getMethod());

		$this->route->setMethod('post');
		$this->assertEquals('POST', $this->route->getMethod());
	}

	public function testKey()
	{
		$this->route->setMethod('GET');
		$this->route->setPattern('hello/world');

		$this->assertEquals(md5("GET:hello/world"), $this->route->getKey());
	}
}

class RouteStub extends RouteKeyable
{
	public function dispatch()
	{
		//
	}
}