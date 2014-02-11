<?php

use \CrazyCodr\Stream\Behaviors\ChunkBehavior;

class ChunkBehaviorTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Tests the next function of this behavior to make sure it returns the appropriate expected results
	 * @param  string $data Data to write to the temporary string and work on to test the results
	 * @param  array $expectedResult Array of string results showing what we expect to get
	 * @dataProvider testNextDataProvider
	 */
	public function testNext($lenght, $data, $expectedResult)
	{

		//Initialize
		$b = new ChunkBehavior($lenght);
		$sh = fopen('php://memory', 'rw');

		//Setup the stream
		fwrite($sh, $data);
		fseek($sh, 0);

		//Test the behavior
		$results = array();
		while(($c = $b->next($sh)) !== null)
		{
			$results[] = $c;
		}

		//Assert both arrays are the same
		$this->assertEquals($expectedResult, $results);

		//Cleanup the stream
		fclose($sh);
		
	}

	/**
	 * Tests if the chunkSize exception works fine
	 * @param  any $sizeToTest An invalid chunk size to test for expcetion thrown
	 * @expectedException \StandardExceptions\ValidationExceptions\InvalidNumberException
	 * @dataProvider testInvalidChunkSizesDataProvider
	 */
	public function testInvalidChunkSizes($sizeToTest)
	{
		$c = new ChunkBehavior($sizeToTest);
	}

	public function testNextDataProvider()
	{
		return array(

			//Test 1, return nothing from empty data
			array(
				'lenght' => 10,
				'data' => '',
				'expectedResult' => array()
			),

			//Test 2, return nothing from just a standard UTF8 BOM
			array(
				'lenght' => 10,
				'data' => chr(239).chr(187).chr(191),
				'expectedResult' => array()
			),

			//Test 3, return unexpected BOM characters when BOM incomplete
			array(
				'lenght' => 10,
				'data' => chr(239).chr(187).chr(194),
				'expectedResult' => array(chr(239).chr(187).chr(194))
			),

			//Test 4, return expected characters from a BOM-less non-utf8 string
			array(
				'lenght' => 10,
				'data' => utf8_decode('été fêtons noël ça'),
				'expectedResult' => array(
					utf8_decode('été fêtons'), 
					utf8_decode(' noël ça'),
				)
			),

			//Test 5, return expected characters from a BOM-less utf8 string
			array(
				'lenght' => 10,
				'data' => 'été fêtons noël ça',
				'expectedResult' => array('été fêtons', ' noël ça')
			),

			//Test 6, return expected characters from a BOM utf8 string
			array(
				'lenght' => 10,
				'data' => chr(239).chr(187).chr(191).'été fêtons noël ça',
				'expectedResult' => array('été fêtons', ' noël ça')
			),

			//Test 7, return expected characters from a BOM-less non-utf8 string
			array(
				'lenght' => 5,
				'data' => utf8_decode('été fêtons noël ça'),
				'expectedResult' => array(
					utf8_decode('été f'), 
					utf8_decode('êtons'),
					utf8_decode(' noël'),
					utf8_decode(' ça'),
				)
			),

			//Test 8, return expected characters from a BOM-less utf8 string
			array(
				'lenght' => 5,
				'data' => 'été fêtons noël ça',
				'expectedResult' => array(
					'été f', 
					'êtons',
					' noël',
					' ça',
				)
			),

			//Test 9, return expected characters from a BOM utf8 string
			array(
				'lenght' => 5,
				'data' => chr(239).chr(187).chr(191).'été fêtons noël ça',
				'expectedResult' => array(
					'été f', 
					'êtons',
					' noël',
					' ça',
				)
			),

		);
	}

	public function testInvalidChunkSizesDataProvider()
	{
		return array(

			array(
				'sizeToTest' => null,
			),

			array(
				'sizeToTest' => 'hello',
			),

			array(
				'sizeToTest' => '34',
			),

			array(
				'sizeToTest' => 0,
			),

			array(
				'sizeToTest' => -84,
			),

		);
	}

}