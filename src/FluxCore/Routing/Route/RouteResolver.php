<?php

namespace FluxCore\Routing\Route;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RouteResolver
{
	protected $routes;
	protected $tokens = array(
		':string' => '([a-zA-Z]+)',
		':int' => '([0-9]+)',
		':alpha' => '([a-zA-Z0-9]+)',
	);

	function __construct(RouteCollection $routes)
	{
		$this->routes = $routes;
	}

	public function resolve(RouteKeyable $id)
	{
		if($this->routes->has($id)) {
			return $this->routes->get($id);
		}

		foreach($this->routes as $key => $route) {
			if($id->getMethod() != $route->getMethod()) {
				continue;
			}

			$pattern = strtr($route->getPattern(), $this->tokens);
			if(preg_match("#^/?{$pattern}/?$#", $id->getPattern(), $matches)) {
				array_shift($matches);
				$route->setArguments($matches);
				
				return $route;
			}
		}

		throw new NotFoundHttpException("Route for pattern '{$id}' was not found.");
	}
}