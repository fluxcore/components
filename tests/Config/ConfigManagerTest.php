<?php

use FluxCore\Config\ConfigManager;
use FluxCore\Config\EngineResolver;
use FluxCore\IO\FileFinder;

class ConfigManagerTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->manager = new ConfigManager(new EngineResolverStub(), new FileFinderStub());
	}

	public function testGetResolverAndFileFinder()
	{
		$this->assertInstanceOf('EngineResolverStub', $this->manager->getResolver());
		$this->assertInstanceOf('FileFinderStub', $this->manager->getFileFinder());
	}

	public function testGet()
	{
		$this->assertEquals(
			array('hello' => 'world', 'test' => 'value'),
			$this->manager->get('test')
		);

		$this->assertEquals(
			'world',
			$this->manager->get('test.hello')
		);

		$this->assertEquals(
			'value',
			$this->manager->get('test.test')
		);

		$this->assertEquals(
			'default_val',
			$this->manager->get('test.notAKey', 'default_val')
		);

		$this->assertEquals(
			'default_val',
			$this->manager->get('does.not.exist', 'default_val')
		);
	}

	public function testArrayAccess()
	{
		$this->assertEquals(
			'value',
			$this->manager['test.test']
		);

		$this->assertEquals(
			array('hello' => 'world', 'test' => 'value'),
			$this->manager['test']
		);
	}
}

class EngineResolverStub extends EngineResolver
{
	public function resolve($file)
	{
		return array('hello' => 'world', 'test' => 'value');
	}
}

class FileFinderStub extends FileFinder
{
	function __construct()
	{
		//
	}

	public function find($abstract, $extension = '*')
	{
		return ($abstract == 'does.not.exist')
			? array()
			: array('file/path');
	}
}