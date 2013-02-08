<?php

use FluxCore\Routing\Route\Route;
use FluxCore\Routing\Route\RouteCollection;
use FluxCore\Routing\Route\RouteIdentifier;

class RouteCollectionTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->collection = new RouteCollection();
	}

	public function testAddHasAndGet()
	{
		$routeIdentifier = new RouteIdentifier('/test/', 'get');
		$route = new Route('/test/', 'get', function()
		{
			return 'Hello World';
		});

		$this->collection->add($route);
		$this->assertTrue($this->collection->has($routeIdentifier));
		$this->assertFalse($this->collection->has(new RouteIdentifier('/does/not/exist', 'post')));
		$this->assertEquals($route, $this->collection->get($routeIdentifier));
	}

	public function testIteratorAggregation()
	{
		$routes_ = array(
			new Route('/test1/', 'get', function(){}),
			new Route('/test2/', 'get', function(){}),
			new Route('/test3/', 'get', function(){}),
			new Route('/test4/', 'get', function(){}),
		);

		$routes = array();
		foreach($routes_ as $route) {
			$routes[$route->getKey()] = $route;
			$this->collection->add($route);
		}

		foreach($this->collection as $key => $route) {
			$this->assertTrue(isset($routes[$key]));
			$this->assertEquals($routes[$key], $route);
			unset($routes[$key]);
		}

		$this->assertEmpty($routes);
	}
}