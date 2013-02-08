<?php

use FluxCore\Routing\Route\RouteIdentifier;
use FluxCore\Routing\Route\RouteCollection;
use FluxCore\Routing\Route\RouteResolver;
use FluxCore\Routing\Router;
use Symfony\Component\HttpFoundation\Request;

class RouterTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->routes = new RouteCollection;
		$this->resolver = new RouteResolver($this->routes);
		$this->router = new Router($this->routes, $this->resolver);
		$this->router->add('/hello/world/', 'get', function()
		{
			return 'Hello World';
		});
	}

	public function testAdd()
	{
		$id = new RouteIdentifier('/hello/world/', 'get');
		$this->assertTrue($this->routes->has($id));
	}

	public function testMagicAdd()
	{
		$this->router->get('/magic/hello/world/', function() {});
		$this->router->post('/magic/post/world/', function() {});

		$id = new RouteIdentifier('/magic/hello/world/', 'get');
		$id2 = new RouteIdentifier('/magic/post/world/', 'post');
		$this->assertTrue($this->routes->has($id));
		$this->assertTrue($this->routes->has($id2));
	}

	public function testResolve()
	{
		$this->assertEquals(
			'Hello World',
			$this->router->resolve('/hello/world/', Request::create('/hello/world/', 'get'))
		);
	}
}