<?php namespace CrazyCodr\Stream\Interfaces;
/**
* Defines the stream iterator interface
*
* @uses \Iterator
* @uses \CrazyCodr\Stream\Interfaces\BehaviorInterface
*
* @package  crazycodr/php-stream-iterators
* @author   Mathieu Dumoulin aka crazycodr <crazyone@crazycoders.net>
* @license  MIT
* @link     https://github.com/crazycodr/php-stream-iterators
*/

//Import list
use \CrazyCodr\Stream\Interfaces\BehaviorInterface;
use \Iterator;

interface StreamIteratorInterface extends Iterator
{
	
	function __construct($content, BehaviorInterface $behavior);
	function setContent($content);
	function setBehavior(BehaviorInterface $behavior);
	function getBehavior();
	function getStreamHandle();

}