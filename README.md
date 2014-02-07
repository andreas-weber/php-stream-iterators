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
2. (Planned) Behavior Interface

#### Iterators
1. (Planned) FileStreamIterator
2. (Planned) StringStreamIterator

#### Behaviors
1. (Planned) CharacterBehavior
2. (Planned) CharacterChunkBehavior
3. (Planned) LineBehavior

Iterators
---------
Iterators are the core item that will be iteratable and return content. Each iterator is used in a specific context.

#### FileStreamIterator
Give it a path to a file and it will open a file stream to it.

```PHP
$iterator = new FileStreamIterator('/path/to/file', new BehaviorInterface());
$iterator = new FileStreamIterator('http://www.favoritesite.com/', new BehaviorInterface());
$iterator = new FileStreamIterator('ftp://user:pass@ftp.favoriteftp.com/foo/bar.txt', new BehaviorInterface());
```

Note that if the stream cannot be opened and read, the constructor will throw a:

```PHP
[\StandardExceptions\IOExceptions\FileNotReadableException](https://github.com/crazycodr/standard-exceptions/blob/master/src/StandardExceptions/IOExceptions/FileNotReadableException.php)
```
_This exception comes from the **crazycodr/standard-exceptions** package_

#### MemoryStreamIterator
Give it a variable and it will use this variable as the content to stream on.

```PHP
$iterator = new StringStreamIterator($longstring, new BehaviorInterface());
```

Note that only strings are accepted. If the initial value is not a string, the constructor will throw a:

```PHP
[\StandardExceptions\LogicExceptions\IllegalArgumentTypeException](https://github.com/crazycodr/standard-exceptions/blob/master/src/StandardExceptions/LogicExceptions/IllegalArgumentTypeException.php)
```
_This exception comes from the **crazycodr/standard-exceptions** package_

Behaviors
---------
Behaviors are used with iterators to define what the iterator will do. An iterator by itself doesn't do anything except iterate. It is the behavior that does affect the stream and return the data.

#### CharacterBehavior
The character behavior returns a single character on each execution.

```PHP
//There are no configuration settings for this behavior
$behavior = new CharacterBehavior();
```

#### CharacterChunkBehavior
The chunk behavior returns a chunk of data as configured on initialization.

```PHP
//First and only parameter is the length of the chunk
$behavior = new CharacterChunkBehavior(10); //Returns 10 characters
```

Note that only positive non-zero integers are accepted. If the initial value is not a positive non-zero integer, the constructor will throw a:

```PHP
[\StandardExceptions\ValidationExceptions\InvalidNumberException](https://github.com/crazycodr/standard-exceptions/blob/master/src/StandardExceptions/ValidationExceptions/InvalidNumberException.php)
```
_This exception comes from the **crazycodr/standard-exceptions** package_

#### LineBehavior
The line behavior returns a single line ended by \r, \n or both characters on each execution.

```PHP
//There are no configuration settings for this behavior
$behavior = new LineBehavior();
```