<?php

use \CrazyCodr\Stream\Behaviors\LineBehavior;

class LineBehaviorTest extends PHPUnit_Framework_TestCase
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
		$b = new LineBehavior();
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
				'expectedResult' => array(chr(239).chr(187).chr(194))
			),

			//Test 4, return expected characters from a BOM-less non-utf8 string
			array(
				'data' => utf8_decode("Bonjour à tous... Voici un énorme\néléphant vêtu d'habits de Noël\rC'est par cette nuit de Noël\r\nque le père noël s'est décidé à faire sa tournée\n\ret d'apporter beaucoup d'amour aux enfants du monde entier"),
				'expectedResult' => array(
					utf8_decode("Bonjour à tous... Voici un énorme"), 
					utf8_decode("éléphant vêtu d'habits de Noël"), 
					utf8_decode("C'est par cette nuit de Noël"), 
					utf8_decode("que le père noël s'est décidé à faire sa tournée"), 
					utf8_decode("et d'apporter beaucoup d'amour aux enfants du monde entier"), 
				)
			),

			//Test 5, return expected characters from a BOM-less utf8 string
			array(
				'data' => "Bonjour à tous... Voici un énorme\néléphant vêtu d'habits de Noël\rC'est par cette nuit de Noël\r\nque le père noël s'est décidé à faire sa tournée\n\ret d'apporter beaucoup d'amour aux enfants du monde entier",
				'expectedResult' => array(
					"Bonjour à tous... Voici un énorme", 
					"éléphant vêtu d'habits de Noël", 
					"C'est par cette nuit de Noël", 
					"que le père noël s'est décidé à faire sa tournée", 
					"et d'apporter beaucoup d'amour aux enfants du monde entier", 
				)
			),

			//Test 6, return expected characters from a BOM utf8 string
			array(
				'data' => chr(239).chr(187).chr(191)."Bonjour à tous... Voici un énorme\néléphant vêtu d'habits de Noël\rC'est par cette nuit de Noël\r\nque le père noël s'est décidé à faire sa tournée\n\ret d'apporter beaucoup d'amour aux enfants du monde entier",
				'expectedResult' => array(
					"Bonjour à tous... Voici un énorme", 
					"éléphant vêtu d'habits de Noël", 
					"C'est par cette nuit de Noël", 
					"que le père noël s'est décidé à faire sa tournée", 
					"et d'apporter beaucoup d'amour aux enfants du monde entier", 
				)
			),

		);
	}

}