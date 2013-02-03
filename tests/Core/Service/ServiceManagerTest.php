<?php

use FluxCore\Core\Service\ServiceManager;
use FluxCore\Core\Service\ServiceProvider;

class ServiceManagerTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->app = new FluxCore\Core\Application;
		$this->manager = new ServiceManager($this->app);
	}

	public function testSuccessfulAddHasAndRemove()
	{
		$this->assertFalse($this->manager->has('\NullServiceStub'));
		$this->manager->add('\NullServiceStub');
		$this->assertTrue($this->manager->has('\NullServiceStub'));
		$this->manager->remove('\NullServiceStub');
		$this->assertFalse($this->manager->has('\NullServiceStub'));
	}

	public function testSuccessfulRegistrationOfProvider()
	{
		$this->manager->add('\TestServiceStub');
		$this->assertEquals('hello all', $this->app['test.hello']);
	}

	public function testAddServiceProviderNotFoundException()
	{
		try {
			$this->manager->add('\NonExistant');
		} catch(RuntimeException $e) {
			$this->assertEquals("'\NonExistant' does not exist.", $e->getMessage());
			return;
		}

		$this->fail('An expected exception has not been raised.');
	}

	public function testAddServiceProviderNotValidException()
	{
		try {
			$this->manager->add('\NoServiceStub');
		} catch(RuntimeException $e) {
			$this->assertEquals("'\NoServiceStub' is not a valid service provider.", $e->getMessage());
			return;
		}

		$this->fail('An expected exception has not been raised.');
	}
}

class NullServiceStub extends ServiceProvider
{
	public function register()
	{
		return;
	}
}

class TestServiceStub extends ServiceProvider
{
	public function register()
	{
		$this->app['test.hello'] = 'hello all';
	}
}

class NoServiceStub { }