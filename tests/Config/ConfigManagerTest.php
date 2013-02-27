<?php

use FluxCore\Config\ConfigManager;
use FluxCore\Config\Configuration;
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
			$this->manager->get('test')->toArray()
		);

		$this->assertEquals(
			'world',
			$this->manager->get('test.hello')
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

	public function testSet()
	{
		$this->manager->set('test.hello', 'not world');
		$this->assertEquals('not world', $this->manager->get('test.hello'));

		$this->manager->set('test', array());

		$this->assertEquals(
			array('hello' => 'not world', 'test' => 'value'),
			$this->manager->get('test')->toArray()
		);
	}

	public function testArrayAccessGet()
	{
		$this->assertEquals(
			'value',
			$this->manager['test.test']
		);

		$this->assertEquals(
			array('hello' => 'world', 'test' => 'value'),
			$this->manager['test']->toArray()
		);

		$this->assertEquals(
			null,
			$this->manager['test.notAKey']
		);

		$this->assertEquals(
			null,
			$this->manager['does.not.exist']
		);
	}

	public function testArrayAccessSet()
	{
		$this->manager['test.hello'] = 'not world';
		$this->assertEquals('not world', $this->manager['test.hello']);

		$this->manager['test'] = array();

		$this->assertEquals(
			array('hello' => 'not world', 'test' => 'value'),
			$this->manager['test']->toArray()
		);
	}
}

class EngineResolverStub extends EngineResolver
{
	protected $config;

	public function resolve($file)
	{
		if (!$this->config) {
			$this->config = new Configuration(array('hello' => 'world', 'test' => 'value'));
		}

		return $this->config;
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
		switch ($abstract) {
			case 'test': return array('file/path');
			default: return array();
		}
	}
}