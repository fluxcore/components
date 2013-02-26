<?php

use FluxCore\Core\FallbackHandler;

class FallbackHandlerTest extends PHPUnit_Framework_TestCase
{
	public function testSuccessfulFallbackHandlerConstruction()
	{
		$handler = new FallbackHandlerStub();

		$this->assertInstanceOf('FallbackHandlerStub', $handler);
	}

	public function testFallbackHandlerFailedDependencyCheck()
	{
		try {
			$handler = new FailFallbackHandlerStub();
		} catch(RuntimeException $e) {
			$this->assertEquals(
				'FallbackHandler failed dependency check, '.
				'missing dependencies: Component, Component2',
				$e->getMessage()
			);

			return;
		}

		$this->fail('Expected RuntimeException was not raised.');
	}
}

class FallbackHandlerStub extends FallbackHandler
{
}

class FailFallbackHandlerStub extends FallbackHandler
{
	public function checkDependencies()
	{
		$this->addMissingDependency('Component');
		$this->addMissingDependency('Component2');
	}
}