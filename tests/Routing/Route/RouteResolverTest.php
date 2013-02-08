<?php

use FluxCore\Routing\Route\Route;
use FluxCore\Routing\Route\RouteCollection;
use FluxCore\Routing\Route\RouteIdentifier;
use FluxCore\Routing\Route\RouteResolver;

class RouteResolverTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->routes = new RouteCollection();
		$this->routes->add(new Route('/hello/world/', 'get', function()
		{
			return 'hello world';
		}));

		$this->resolver = new RouteResolver($this->routes);
	}

	public function testResolveSimple()
	{
		$route = $this->resolver->resolve(new RouteIdentifier('/hello/world/', 'get'));
		$this->assertInstanceOf('FluxCore\Routing\Route\Route', $route);
		$this->assertEquals('hello world', $route->dispatch());
	}

	public function testResolveAdvanced()
	{
		$this->routes->add(new Route('/test/:string/', 'get', function($name)
		{
			return "Hello $name";
		}));

		$id = new RouteIdentifier('/test/john', 'get');
		$this->assertEquals(
			'Hello john',
			$this->resolver->resolve($id)->dispatch()
		);
	}
}