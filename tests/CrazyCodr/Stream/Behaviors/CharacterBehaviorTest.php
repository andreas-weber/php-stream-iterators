<?php

use \CrazyCodr\Stream\Behaviors\CharacterBehavior;

class CharacterBehaviorTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Tests the next function of this behavior to make sure it returns the appropriate expected results
	 * @param  string $data Data to write to the temporary string and work on to test the results
	 * @param  array $expectedResult Array of string results showing what we expect to get
	 * @dataProvider testNextDataProvider
	 */
	public function testNext($data, $expectedResult)
	{

		//Initialize
		$b = new CharacterBehavior();
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

	public function testNextDataProvider()
	{
		return array(

			//Test 1, return nothing from empty data
			array(
				'data' => '',
				'expectedResult' => array()
			),

			//Test 2, return nothing from just a standard UTF8 BOM
			array(
				'data' => chr(239).chr(187).chr(191),
				'expectedResult' => array()
			),

			//Test 3, return unexpected BOM characters when BOM incomplete
			array(
				'data' => chr(239).chr(187).chr(194),
				'expectedResult' => array(chr(239), chr(187), chr(194))
			),

			//Test 4, return expected characters from a BOM-less non-utf8 string
			array(
				'data' => utf8_decode('été fêtons noël ça'),
				'expectedResult' => array(
					utf8_decode('é'), 
					utf8_decode('t'), 
					utf8_decode('é'), 
					utf8_decode(' '), 
					utf8_decode('f'), 
					utf8_decode('ê'), 
					utf8_decode('t'), 
					utf8_decode('o'), 
					utf8_decode('n'), 
					utf8_decode('s'), 
					utf8_decode(' '), 
					utf8_decode('n'), 
					utf8_decode('o'), 
					utf8_decode('ë'), 
					utf8_decode('l'), 
					utf8_decode(' '), 
					utf8_decode('ç'), 
					utf8_decode('a')
				)
			),

			//Test 5, return expected characters from a BOM-less utf8 string
			array(
				'data' => 'été fêtons noël ça',
				'expectedResult' => array('é', 't', 'é', ' ', 'f', 'ê', 't', 'o', 'n', 's', ' ', 'n', 'o', 'ë', 'l', ' ', 'ç', 'a')
			),

			//Test 6, return expected characters from a BOM utf8 string
			array(
				'data' => chr(239).chr(187).chr(191).'été fêtons noël ça',
				'expectedResult' => array('é', 't', 'é', ' ', 'f', 'ê', 't', 'o', 'n', 's', ' ', 'n', 'o', 'ë', 'l', ' ', 'ç', 'a')
			),

		);
	}

}