<?php

use FluxCore\Config\Configuration;

class ConfigurationTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->c = new Configuration(array('hello' => 'world'));
	}

	public function testGet()
	{
		$this->assertEquals('world', $this->c->hello);
	}

	public function testSet()
	{
		$this->c->hello = 'not world';
		$this->assertEquals('not world', $this->c->hello);
	}

	public function testGetArrayAccess()
	{
		$this->assertEquals('world', $this->c['hello']);
	}

	public function testSetArrayAccess()
	{
		$this->c['hello'] = 'not world';
		$this->assertEquals('not world', $this->c['hello']);
	}

	public function testToArray()
	{
		$this->assertEquals(array('hello' => 'world'), $this->c->toArray());
	}
}