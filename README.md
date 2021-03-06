[![Latest Stable Version](https://poser.pugx.org/crazycodr/php-stream-iterators/version.png)](https://packagist.org/packages/crazycodr/php-stream-iterators) [![Total Downloads](https://poser.pugx.org/crazycodr/php-stream-iterators/downloads.png)](https://packagist.org/packages/crazycodr/php-stream-iterators) [![Build Status](https://travis-ci.org/crazycodr/php-stream-iterators.png?branch=master)](https://travis-ci.org/crazycodr/php-stream-iterators)
php-stream-iterators
====================

A collection of simple iterators that work on php streams to acquire data from them.

Installation
------------

To install it, just include this requirement into your composer.json

```JSON
{
    "require": {
        "crazycodr/php-stream-iterators": "1.*"
    }
}
```
And then run composer install/update as necessary.

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
#### [Interfaces](docs/interfaces)
1. [StreamIteratorInterface](docs/interfaces/StreamIteratorInterface.md)
2. [BehaviorInterface](docs/interfaces/BehaviorInterface.md)

#### [Iterators](docs/iterators)
1. [FileStreamIterator](docs/iterators/FileStreamIterator.md)
2. [MemoryStreamIterator](docs/iterators/MemoryStreamIterator.md)

#### [Behaviors](docs/behaviors)
1. [CharacterBehavior](docs/behaviors/CharacterBehavior.md)
2. [CharacterChunkBehavior](docs/behaviors/CharacterChunkBehavior.md)
3. [LineBehavior](docs/behaviors/LineBehavior.md)
