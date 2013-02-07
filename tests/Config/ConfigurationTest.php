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
		try {
			$this->c->hello = 'not world';
		} catch(RuntimeException $e) {
			$this->assertEquals(
				'Configuration does not allow modifications.',
				$e->getMessage()
			);

			return;
		}

		$this->fail('Expected RuntimeException was not raised.');
	}

	public function testGetArrayAccess()
	{
		$this->assertEquals('world', $this->c['hello']);
	}

	public function testSetArrayAccess()
	{
		try {
			$this->c['hello'] = 'not world';
		} catch(RuntimeException $e) {
			$this->assertEquals(
				'Configuration does not allow modifications.',
				$e->getMessage()
			);

			return;
		}

		$this->fail('Expected RuntimeException was not raised.');
	}

	public function testToArray()
	{
		$this->assertEquals(array('hello' => 'world'), $this->c->toArray());
	}
}