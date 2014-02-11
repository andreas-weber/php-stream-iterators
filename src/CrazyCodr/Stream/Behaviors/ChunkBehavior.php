<?php namespace CrazyCodr\Stream\Behaviors;
/**
* Defines the chunk behavior.
* This behavior simply fetches a chunk of characters from the stream and returns it.
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

class ChunkBehavior implements BehaviorInterface
{

    /**
     * Contains the size of the chunk to get
     *
     * @var int
     *
     * @access protected
     */
	protected $chunkSize = 10;

    /**
     * Builds a new ChunkBehavior
     * 
     * @param int $chunkSize Size of the chunk to read on each next()
     *
     * @throws \StandardExceptions\ValidationExceptions\InvalidNumberException when $chunkSize is invalid
     *
     * @access public
     */
	public function __construct($chunkSize = 10)
	{

		//If the chunkSize is not a valid integer, throw a standard exception about it
		if(!is_int($chunkSize) || $chunkSize <= 0)
		{
			throw new \StandardExceptions\ValidationExceptions\InvalidNumberException();
		}

		//Save the settings
		$this->chunkSize = $chunkSize;

	}
	
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
			$chunk .= $nextChar;
			if(mb_detect_encoding($chunk) == 'UTF-8')
			{
				if(mb_strlen(utf8_decode($chunk)) >= $this->chunkSize)
				{
					return $chunk;
				}
			}
			else
			{
				if(mb_strlen($chunk) >= $this->chunkSize)
				{
					return $chunk;
				}
			}
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
				//Ok, BOM skipped, read next char using defined next method (to support possible UTF-8 chars)
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