php-stream-iterators
====================

A collection of simple iterators that work on php streams to acquire data from them.

Current iterators
-----------------
1. (Planned) FileStreamIterator
2. (Planned) MemoryStreamIterator

Current behaviors
-----------------
1. (Planned) CharacterBehavior
2. (Planned) ChunkBehavior
3. (Planned) LineBehavior

Use cases and examples
======================
Use these stream iterators to return content in a stream like fashion meaning you won't need to load the whole stream into memory. Very useful for large files or for web services that return sequential data.

```PHP
//Outputs only digits from the file
$myFile = new FileStreamIterator('/path/to/file', new CharacterBehavior());
foreach($myFile as $char)
{
	if(is_digit($char))
	{
		echo $char;	
	}
}
```

Iterators
=========
Iterators are the core item that will be iteratable and return content. Each iterator is used in a specific context.

FileStreamIterator
------------------
Give it a path to a file and it will open a file stream to it.

MemoryStreamIterator
--------------------
Give it a variable and it will use this variable as the content to stream on.

Behaviors
=========
Behaviors are used with iterators to define what the iterator will do. An iterator by itself doesn't do anything except iterate. It is the behavior that does affect the stream and return the data.

CharacterBehavior
-----------------
The character behavior returns a single character on each execution.

ChunkBehavior
-------------
The chunk behavior returns a chunk of data as configured on initialization.

LineBehavior
------------
The line behavior returns a single line ended by \r, \n or both characters on each execution.