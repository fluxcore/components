<?php

use FluxCore\Routing\Route\Route;
use FluxCore\Routing\Route\RouteCollection;
use FluxCore\Routing\Route\RouteIdentifier;
use FluxCore\Routing\Route\RouteResolver;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

	public function testResolveNotFoundHttpException()
	{
		$id = new RouteIdentifier('/404/not/found/', 'get');

		try {
			$this->resolver->resolve($id);
		} catch(NotFoundHttpException $e) {
			$this->assertEquals(
				"Route for pattern 'GET:404/not/found' was not found.",
				$e->getMessage()
			);

			return;
		}

		$this->fail('Expected RouteNotFoundException was not raised.');
	}
}