php-stream-iterators
====================

A collection of simple iterators that work on php streams to acquire data from them.

Use cases and examples
----------------------
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

Current classes provided
------------------------
#### Interfaces
1. (Planned) StreamIteratorInterface
2. (Planned) BehaviorInterface

#### Iterators
1. (Planned) FileStreamIterator
2. (Planned) StringStreamIterator

#### Behaviors
1. (Planned) CharacterBehavior
2. (Planned) CharacterChunkBehavior
3. (Planned) LineBehavior