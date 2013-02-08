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

	public function testMake()
	{
		$this->assertEquals(
			array('hello', 'world'),
			$this->manager->make('does.exist')
		);
	}

	public function testMakeFileNotFoundException()
	{
		try {
			$this->manager->make('does.not.exist');
		} catch(RuntimeException $e) {
			$this->assertEquals(
				"The configuration for 'does.not.exist' does not exist.",
				$e->getMessage()
			);

			return;
		}

		$this->fail('Expected RuntimeException was not raised.');
	}

	public function testArrayAccess()
	{
		$this->assertEquals(
			array('hello', 'world'),
			$this->manager['does.exist']
		);
	}
}

class EngineResolverStub extends EngineResolver
{
	public function resolve($file)
	{
		return array('hello', 'world');
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