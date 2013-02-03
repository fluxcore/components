<?php

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

function closure_proxy($c, $a)
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