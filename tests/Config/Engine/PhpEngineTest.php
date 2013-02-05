<?php

use FluxCore\Config\Engine\PhpEngine;

class PhpEngineTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->engine = new PhpEngine();
		file_put_contents(__DIR__.'/test.php', "<?php return array('hello' => 'world');");
	}

	public function tearDown()
	{
		unlink(__DIR__.'/test.php');
	}

	public function testParse()
	{
		$this->assertEquals(
			array('hello' => 'world'),
			$this->engine->parse(__DIR__.'/test.php')->toArray()
		);
	}
}