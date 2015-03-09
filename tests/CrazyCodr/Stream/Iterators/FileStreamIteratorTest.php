<?php

use \CrazyCodr\Stream\Interfaces\BehaviorInterface;
use \CrazyCodr\Stream\Iterators\FileStreamIterator;

class FileStreamIteratorTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Tests the iteration process making sure expected data is returned
	 */
	public function testIteration()
	{

		//Build the expectation
		$e = array(1 => 'Hello', 2 => 'world', 3 => 'loved', 4 => 'it all');

		//Mock a behavior interface to force the return values of it
		$behavior = Mockery::mock('\CrazyCodr\Stream\Interfaces\BehaviorInterface');
		$behavior->shouldReceive('next')->andReturnValues(array_values($e + array(null)));

		//Initialize a memory stream iterator
		//I'm passing __FILE__ here because we don't actually care what the file is, since the behavior is mocked
		$i = new FileStreamIterator(__FILE__, $behavior);

		//Build the result
		$r = iterator_to_array($i);

		//Assert both arrays are the same
		$this->assertEquals($e, $r);

	}

	/**
	 * Tests the file not found process
	 * @expectedException \StandardExceptions\IOExceptions\FileNotReadableException
	 */
	public function testFileNotReadableException()
	{

		//Build the expectation
		$e = array(1 => 'Hello', 2 => 'world', 3 => 'loved', 4 => 'it all');

		//Mock a behavior interface to force the return values of it
		$behavior = Mockery::mock('\CrazyCodr\Stream\Interfaces\BehaviorInterface');
		$behavior->shouldReceive('next')->andReturnValues(array_values($e + array(null)));

		//Initialize a file stream iterator on a missing file
		$i = new FileStreamIterator(__FILE__.'ABC', $behavior);

	}

    /**
     *
     */
	public function testBlankLineWillBeRecognizedAsBlankLineAndNotNull()
	{
		$e = array(
			1 => 'Hello',
			2 => '',
			3 => 'loved',
			4 => 'it all'
		);

		$behavior = Mockery::mock('\CrazyCodr\Stream\Interfaces\BehaviorInterface');
		$behavior->shouldReceive('next')->andReturnValues(array_values($e + array(null)));

		$i = new FileStreamIterator(__FILE__, $behavior);
		$r = iterator_to_array($i);

		$this->assertEquals($e, $r);
	}
}
