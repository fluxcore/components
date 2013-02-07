<?php

use FluxCore\Routing\Route;
use FluxCore\Routing\RouteCollection;

class RouteCollectionTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->collection = new RouteCollection();
	}

	public function testAddHasAndGet()
	{
		$routeFinder = new Route('/test/', 'get');
		$route = new Route('/test/', 'get', function()
		{
			return 'Hello World';
		});

		$this->collection->add($route);
		$this->assertTrue($this->collection->has($route));
		$this->assertFalse($this->collection->has(new Route('/does/not/exist', 'post')));
		$this->assertEquals($route, $this->collection->get($route));
	}

	public function testIteratorAggregation()
	{
		$routes_ = array(
			new Route('/test1/', 'get'),
			new Route('/test2/', 'get'),
			new Route('/test3/', 'get'),
			new Route('/test4/', 'get'),
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