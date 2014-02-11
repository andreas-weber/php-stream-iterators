<?php namespace CrazyCodr\Stream\Behaviors;
/**
* Defines the line behavior.
* This behavior simply fetches the next whole line from the stream and returns it.
* When the behavior detects a \n, \r or both in any order, it returns a new line. This behavior needs 
* to peek ahead to find the double characters.
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

class LineBehavior implements BehaviorInterface
{
	
    /**
     * Fetches the next item from the stream using defined behavior
     * 
     * @param resource $stream_handle The stream handle that is being use in the current context
     *
     * @access public
     *
     * @return string A chunk of characters or null if FEOF
     */
	public function next($stream_handle)
	{

		//While the chunk is under chunksize, get the next character or exit if nothing left
		$chunk = '';
		while(($nextChar = $this->getNextCharFromStream($stream_handle)) != null)
		{

			//Detect newline, if any new line character is found
			if($nextChar == chr(10) || $nextChar == chr(13))
			{

				//Peek ahead to find the next character
				$nextChar2 = $this->getNextCharFromStream($stream_handle);

				//If the current and next characters from a CR+LF or LF+CR, return the buffer, if not rollback the seek ahead and return the buffer
				//A new line was still discovered
				if(($nextChar == chr(10) && $nextChar2 == chr(13)) || ($nextChar == chr(13) && $nextChar2 == chr(10)))
				{
					//Return the buffer, the nextChar and nextChar2 are automatically discarded because they are read from the buffer
					return $chunk;
				}
				else
				{
					//Rollback the stream by mb_strlen characters from nextChar2 to make sure we read it later
					//and return the chunk
					fseek($stream_handle, ftell($stream_handle) - mb_strlen($nextChar2));
					return $chunk;
				}

			}

			//Append the char
			$chunk .= $nextChar;
			
		}

		//If the chunk is empty, return null to signal end of stream, else return only whats available (partial chunk because of EOF)
		return ($chunk == '' ? null : $chunk);

	}

    /**
     * Returns the next character from the stream taking UTF-8 into account
     * 
     * @param resource $stream_handle The stream handle that is being use in the current context
     *
     * @access protected
     *
     * @return string Next character in the stream or NULL if EOF
     */
	protected function getNextCharFromStream($stream_handle)
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
				//Ok, BOM skipped, read next char using defined getNextCharFromStream method (to support possible UTF-8 chars)
				$c = $this->getNextCharFromStream($stream_handle);
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