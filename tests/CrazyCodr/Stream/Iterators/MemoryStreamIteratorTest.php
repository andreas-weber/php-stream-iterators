<?php

use \CrazyCodr\Stream\Interfaces\BehaviorInterface;
use \CrazyCodr\Stream\Iterators\MemoryStreamIterator;

class MemoryStreamIteratorTest extends PHPUnit_Framework_TestCase
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
		$i = new MemoryStreamIterator($data = 'Helloworldlovedit all', $behavior);

		//Build the result
		$r = iterator_to_array($i);

		//Assert both arrays are the same
		$this->assertEquals($e, $r);
		
	}

	/**
	 * Tests the invalid argument type
	 * @expectedException \StandardExceptions\LogicExceptions\IllegalArgumentTypeException
	 */
	public function testInvalidTypeArgumentException()
	{

		//Build the expectation
		$e = array(1 => 'Hello', 2 => 'world', 3 => 'loved', 4 => 'it all');

		//Mock a behavior interface to force the return values of it
		$behavior = Mockery::mock('\CrazyCodr\Stream\Interfaces\BehaviorInterface');
		$behavior->shouldReceive('next')->andReturnValues(array_values($e + array(null)));

		//Initialize a memory stream iterator
		$i = new MemoryStreamIterator($data = 12, $behavior);
		
	}

}