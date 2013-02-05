<?php

use FluxCore\Config\Configuration;

class ConfigurationTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->c = new Configuration(array('hello' => 'world'));
	}

	public function testConstructAndSetAndGet()
	{
		$this->c->hello = 'not world'; // Ineffective
		$this->assertEquals('world', $this->c->hello);
	}

	public function testArrayAccess()
	{
		$this->c['hello'] = 'not world'; // Ineffective
		$this->assertEquals('world', $this->c['hello']);
	}

	public function testToArray()
	{
		$this->assertEquals(array('hello' => 'world'), $this->c->toArray());
	}
}