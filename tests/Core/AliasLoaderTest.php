<?php

use FluxCore\Core\AliasLoader;

class AliasLoaderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		AliasLoader::addAliases(array('Stub' => 'LongNameStubClass'));
	}

	public function testLoad()
	{
		$this->assertFalse(class_exists('Stub'));
		$this->assertFalse(AliasLoader::load('Stub'));
		$this->assertTrue(class_exists('Stub'));
	}
}

class LongNameStubClass
{}