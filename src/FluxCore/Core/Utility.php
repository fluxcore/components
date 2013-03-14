<?php

/**
 * Proxies a method call.
 *
 * This is an optimized utility function that is used
 * to invoke a certain method on a certain class with
 * the specified arguments.
 * 
 * @param object $c The class to invoke the method on.
 * @param string $m The method to invoke.
 * @param array $a The arguments to invoke the method with.
 * @return mixed The result of the proxied invokation.
 */
function method_proxy($c, $m, $a)
{
	switch(sizeof($a)) {
		case 0: return $c->{$m}();
		case 1: return $c->{$m}($a[0]);
		case 2: return $c->{$m}($a[0], $a[1]);
		case 3: return $c->{$m}($a[0], $a[1], $a[2]);
		case 4: return $c->{$m}($a[0], $a[1], $a[2], $a[3]);
		case 5: return $c->{$m}($a[0], $a[1], $a[2], $a[3], $a[4]);
		default: return call_user_func_array(array($c, $m), $a);
	}
}

/**
 * Proxies a closure call.
 * @param Closure $c The closure to invoke.
 * @param array $a The arguments to invoke the closure with.
 * @return mixed The result of the proxied invokation.
 */
function closure_proxy(Closure $c, $a)
{
	switch(sizeof($a)) {
		case 0: return $c();
		case 1: return $c($a[0]);
		case 2: return $c($a[0], $a[1]);
		case 3: return $c($a[0], $a[1], $a[2]);
		case 4: return $c($a[0], $a[1], $a[2], $a[3]);
		case 5: return $c($a[0], $a[1], $a[2], $a[3], $a[4]);
		default: return call_user_func_array($c, $a);
	}
}

/**
 * Get file extension from path.
 * 
 * @param string $path The path to get the file extension from.
 * @return string The file extension of the path.
 */
function file_extension($path)
{
	$explode = explode('.', $path);
	return end($explode);
}