<?php namespace CrazyCodr\Stream\Interfaces;
/**
* Defines the behavior interface
*
* @package  crazycodr/php-stream-iterators
* @author   Mathieu Dumoulin aka crazycodr <crazyone@crazycoders.net>
* @license  MIT
* @link     https://github.com/crazycodr/php-stream-iterators
*/

interface BehaviorInterface
{
	
	function next($stream_handle);

}