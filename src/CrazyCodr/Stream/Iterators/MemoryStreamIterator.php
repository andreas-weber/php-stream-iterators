<?php namespace CrazyCodr\Stream\Iterators;
/**
* Defines the MemoryStreamIterator.
* This iterator opens a stream towards php://memory and writes the content of a string variable to it.
* You can then iterate over the memory stream easily
*
* @package  crazycodr/php-stream-iterators
* @author   Mathieu Dumoulin aka crazycodr <crazyone@crazycoders.net>
* @license  MIT
* @link     https://github.com/crazycodr/php-stream-iterators
*/

//Import list
use \CrazyCodr\Stream\Interfaces\BehaviorInterface;
use \CrazyCodr\Stream\Interfaces\StreamIteratorInterface;

class MemoryStreamIterator implements StreamIteratorInterface
{

    /**
     * Contains the behavior to apply on each iteration
     *
     * @var BehaviorInterface
     *
     * @access protected
     */
	protected $behavior = null;

    /**
     * Contains the stream handle used to process the stream resource
     *
     * @var Resource
     *
     * @access protected
     */
	protected $stream_handle = null;

    /**
     * Contains the current value of the iterator, if null, means iterator is BOF or EOF
     *
     * @var mixed
     *
     * @access protected
     */
	protected $current_value = null;

    /**
     * Contains the current key of the iterator, if null, means iterator is BOF or EOF
     *
     * @var mixed
     *
     * @access protected
     */
	protected $current_key = null;
	
    /**
     * Builds a new MemoryStreamIterator
     * 
     * @param mixed $content A valid string that will be copied into memory stream
     * @param BehaviorInterface A behavior to apply on each iteration
     *
     * @throws \StandardExceptions\LogicExceptions\IllegalArgumentTypeException when the content is not of the correct expected type (string only)
     *
     * @access public
     */
	public function __construct($content, BehaviorInterface $behavior)
	{
		$this->setContent($content);
		$this->setBehavior($behavior);
	}

    /**
     * Cleans up the object by closing the stream
     * 
     * @access public
     */
	public function __destruct()
	{

		//If there is already a stream, close it
		if($this->stream_handle)
		{
			@fclose($this->stream_handle);
		}

	}

    /**
     * Sets the content to work on by initializing the stream with new content
     * If there was already something initialized, it is closed
     * 
     * @param mixed $content Description.
     *
     * @access public
     *
     * @return mixed Value.
     */
	public function setContent($content)
	{

		//If there is already a stream, close it
		if($this->stream_handle)
		{
			@fclose($this->stream_handle);
		}

		//If not a string, throw exception
		if(!is_string($content))
		{
			throw new \StandardExceptions\LogicExceptions\IllegalArgumentTypeException();
		}

		//Initialize the stream to work on
		$this->stream_handle = @fopen('php://memory', 'rw');

		//Write the content to it
		fwrite($this->stream_handle, $content);
		fseek($this->stream_handle, 0);

	}

    /**
     * Sets the behavior to use when iterating the stream
     * 
     * @param BehaviorInterface Behavior to apply on each iteration
     *
     * @access public
     */
	public function setBehavior(BehaviorInterface $behavior)
	{
		$this->behavior = $behavior;
	}

    /**
     * Returns the currently assigned behavior
     * 
     * @access public
     *
     * @return BehaviorInterface Behavior bound to the stream
     */
	public function getBehavior()
	{
		return $this->behavior;
	}

    /**
     * Returns the stream handle of the stream resource
     * 
     * @access public
     *
     * @return Resource Stream handle returned by fopen
     */
	public function getStreamHandle()
	{
		return $this->stream_handle;
	}

    /**
     * Resets the stream to position 0
     * 
     * @access public
     */
	public function rewind()
	{
		fseek($this->stream_handle, 0);
		$this->current_key = 0;
		$this->current_value = null;
		$this->next();
	}

    /**
     * Gets the next item from the stream based on behavior
     * 
     * @access public
     */
	public function next()
	{
		$c = $this->behavior->next($this->stream_handle);
		if($c == null)
		{
			$this->current_key = null;
			$this->current_value = null;
		}
		else
		{
			$this->current_key++;
			$this->current_value = $c;
		}
	}

    /**
     * Detects if the item we are on right now is valid or EOF
     * 
     * @access public
     *
     * @return bool Is the current item valid or EOF
     */
	public function valid()
	{
		return $this->current_key != null;
	}

    /**
     * Returns the current value
     * 
     * @access public
     *
     * @return mixed Value
     */
	public function current()
	{
		return $this->current_value;
	}

    /**
     * Returns the current key
     * 
     * @access public
     *
     * @return mixed Key
     */
	public function key()
	{
		return $this->current_key;
	}

}