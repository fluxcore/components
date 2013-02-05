<?php

use FluxCore\IO\FileFinder;

class FileFinderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->finder = new FileFinder(__DIR__.'/');
		touch(__DIR__.'/test.ini');
		touch(__DIR__.'/test.php');
		mkdir(__DIR__.'/hello');
		touch(__DIR__.'/hello/test.inc');
	}

	public function tearDown()
	{
		unlink(__DIR__.'/test.ini');
		unlink(__DIR__.'/test.php');
		unlink(__DIR__.'/hello/test.inc');
		rmdir(__DIR__.'/hello');
	}

	public function testFindFile()
	{
		$this->assertEquals(
			array(
				__DIR__.'/test.ini',
				__DIR__.'/test.php',
			),
			$this->finder->find('test')
		);

		$this->assertEquals(
			array(
				__DIR__.'/hello/test.inc'
			),
			$this->finder->find('hello.test')
		);

		$this->assertEquals(
			array(),
			$this->finder->find('nope')
		);
	}

	public function testConstructPathDoesNotExist()
	{
		try {
			$finder = new FileFinder('/does/not/exist/');
		} catch(RuntimeException $e) {
			$this->assertEquals(
				"The path '/does/not/exist/' does not exist.",
				$e->getMessage()
			);

			return;
		}
		
		$this->fail('Expected RuntimeException was not raised.');
	}
}