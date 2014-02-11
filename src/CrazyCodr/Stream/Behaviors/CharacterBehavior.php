<?php namespace CrazyCodr\Stream\Behaviors;
/**
* Defines the character behavior.
* This behavior simply fetches the next character from the stream and returns it.
*
* Note the behavior itself doesn't take byte order marks, it returns content as it goes.
*
* @package  crazycodr/php-stream-iterators
* @author   Mathieu Dumoulin aka crazycodr <crazyone@crazycoders.net>
* @license  MIT
* @link     https://github.com/crazycodr/php-stream-iterators
*/

//Import list
use \CrazyCodr\Stream\Interfaces\BehaviorInterface;

class CharacterBehavior implements BehaviorInterface
{
	
    /**
     * Fetches the next item from the stream using defined behavior
     * 
     * @param resource $stream_handle The stream handle that is being use in the current context
     *
     * @access public
     *
     * @return string A single character or null if FEOF
     */
	public function next($stream_handle)
	{

		//If feof, end it
		if(feof($stream_handle))
		{
			return null;
		}

		//Extract the character
		$c = (($c = fgetc($stream_handle)) === false ? null : $c);

		//If character is 195 (utf8 control character)
		if($c !== null && ord($c) == 195)
		{
			$c .= fgetc($stream_handle);
		}

		//If character is 195 (utf8 control character)
		if($c !== null && ord($c) == 239)
		{
			//Get the next two characters and seek back if not UTF8 bom
			$c2 = fgetc($stream_handle);
			$c3 = fgetc($stream_handle);
			if(ord($c2) == 187 && ord($c3) == 191)
			{
				//Ok, BOM skipped, read next char using defined next method (to support possible UTF-8 chars)
				$c = $this->next($stream_handle);
			}
			else
			{
				//Seek back 2 characters, it was not a UTF-8 BOM
				fseek($stream_handle, ftell($stream_handle) - 2);
			}
		}

		//Return it
		return $c;

	}

}