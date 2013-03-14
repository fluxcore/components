<?php

namespace FluxCore\Routing;

use FluxCore\Routing\Route\Route;
use FluxCore\Routing\Route\RouteCollection;
use FluxCore\Routing\Route\RouteIdentifier;
use FluxCore\Routing\Route\RouteResolver;
use Symfony\Component\HttpFoundation\Request;

/**
 * Router class.
 */
class Router
{
	/**
	 * The routes that have been assigned to the router.
	 * 
	 * @var FluxCore\Routing\Route\RouteCollection
	 */
	protected $routes;

	/**
	 * The route resolver.
	 * 
	 * @var FluxCore\Routing\Route\RouteResolver
	 */
	protected $resolver;

	/**
	 * Creates a new router instance.
	 * 
	 * @param FluxCore\Routing\Route\RouteCollection $routes
	 * @param FluxCore\Routing\Route\RouteResolver $resolver
	 */
	function __construct(RouteCollection $routes, RouteResolver $resolver)
	{
		$this->routes = $routes;
		$this->resolver = $resolver;
	}

	/**
	 * Method fallback.
	 *
	 * Provides a shorthand for route assignment.
	 * 
	 * @param string $method
	 * @param array $args
	 */
	function __call($method, $args)
	{
		$pattern = array_shift($args);
		$handler = array_shift($args);

		method_proxy($this, 'add', array($pattern, $method, $handler));
	}

	/**
	 * Add route to router.
	 * 
	 * @param string $pattern
	 * @param string $method
	 * @param Closure $handler
	 */
	public function add($pattern, $method, \Closure $handler)
	{
		$this->routes->add(new Route($pattern, $method, $handler));
	}

	/**
	 * Dispatch path from request.
	 * 
	 * @param string $path
	 * @param Symfony\Component\HttpFoundation\Request $request
	 * @return mixed
	 */
	public function dispatch($path, Request $request)
	{
		$id = new RouteIdentifier(
			$path,
			$request->getMethod()
		);
		
		return $this->resolver->resolve($id)->dispatch();
	}
}