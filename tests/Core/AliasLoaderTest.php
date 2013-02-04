<?php

use FluxCore\Core\AliasLoader;

class AliasLoaderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->loader = new AliasLoader();
		$this->loader->register();
	}

	public function testFindFile()
	{
		$this->loader->addAliasMap(array('Test' => 'TestFile'));
		$this->assertFalse(class_exists('ThisIsANonExistantClass'));
		$this->assertTrue(class_exists('TestFile'));
		$this->assertTrue(class_exists('Test'));
		$this->assertFalse(class_exists('Testing'));
	}
}

class TestFile
{
	public function hello()
	{
		return 'World';
	}
}