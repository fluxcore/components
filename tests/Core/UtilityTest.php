<?php

class UtilityTest extends PHPUnit_Framework_TestCase
{
	public function testMethodProxy()
	{
		$o = new ProxyStub();
		$this->assertEquals(
			'Hello john, eve, adam!',
			method_proxy($o, 'hello', array('john', 'eve', 'adam'))
		);
	}

	public function testClosureProxy()
	{
		$c = function() { return 'Hello '.implode(', ', func_get_args()).'!'; };
		$this->assertEquals(
			'Hello john, eve, adam!',
			closure_proxy($c, array('john', 'eve', 'adam'))
		);
	}
}

class ProxyStub
{
	public function hello()
	{
		return 'Hello '.implode(', ', func_get_args()).'!';
	}
}