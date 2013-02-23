<?php

namespace FluxCore\Routing;

use FluxCore\Routing\Route\Route;
use FluxCore\Routing\Route\RouteCollection;
use FluxCore\Routing\Route\RouteIdentifier;
use FluxCore\Routing\Route\RouteResolver;
use Symfony\Component\HttpFoundation\Request;

class Router
{
	protected $routes;
	protected $resolver;

	function __construct(RouteCollection $routes, RouteResolver $resolver)
	{
		$this->routes = $routes;
		$this->resolver = $resolver;
	}

	function __call($method, $args)
	{
		$pattern = array_shift($args);
		$handler = array_shift($args);

		return method_proxy($this, 'add', array($pattern, $method, $handler));
	}

	public function add($pattern, $method, \Closure $handler)
	{
		$this->routes->add(new Route($pattern, $method, $handler));
	}

	public function dispatch($path, Request $request)
	{
		$id = new RouteIdentifier(
			$path,
			$request->getMethod()
		);
		
		return $this->resolver->resolve($id)->dispatch();
	}
}