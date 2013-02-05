<?php

use FluxCore\Config\EngineResolver;
use FluxCore\Config\Engine\EngineInterface;

class EngineResolverTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->resolver = new EngineResolver();
		$this->resolver->register('php', new PhpEngineStub());
		$this->resolver->register('ini', new IniEngineStub());
	}

	public function testResolve()
	{
		$this->assertEquals(
			array('php', 'hello', 'world'),
			$this->resolver->resolve('hello.php')
		);

		$this->assertEquals(
			array('ini', 'hello', 'world'),
			$this->resolver->resolve('hello.ini')
		);
	}

	public function testResolveInvalidExtensionException()
	{
		try {
			$this->resolver->resolve('hello.yaml');
		} catch(RuntimeException $e) {
			$this->assertEquals(
				"There's no engine assigned for the 'yaml' file-format.",
				$e->getMessage()
			);

			return;
		}

		$this->fail('Expected RuntimeException was not raised.');
	}
}

class PhpEngineStub implements EngineInterface
{
	public function parse($file)
	{
		return array('php', 'hello', 'world');
	}
}

class IniEngineStub implements EngineInterface
{
	public function parse($file)
	{
		return array('ini', 'hello', 'world');
	}
}