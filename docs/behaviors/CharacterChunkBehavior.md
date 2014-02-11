CharacterChunkBehavior
======================
The chunk behavior returns a chunk of data as configured on initialization.

Instanciation
-------------
```PHP
//First and only parameter is the length of the chunk
$behavior = new CharacterChunkBehavior(10); //Returns 10 characters
```

Note that only positive non-zero integers are accepted. If the initial value is not a positive non-zero integer, the constructor will throw a: [\StandardExceptions\ValidationExceptions\InvalidNumberException](https://github.com/crazycodr/standard-exceptions/blob/master/src/StandardExceptions/ValidationExceptions/InvalidNumberException.php)

_This exception comes from the **[crazycodr/standard-exceptions](https://github.com/crazycodr/standard-exceptions)** package_

Usage
-----
Simply instanciate it and loop it until next() returns null
```PHP
while(($c = $behavior->next($stream_handle)) !== null)
{
	//Do something with $c
}
```