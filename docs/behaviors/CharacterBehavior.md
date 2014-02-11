CharacterBehavior
=================
The character behavior returns a single character on each execution.

Instanciation
-------------
```PHP
//There are no configuration settings for this behavior
$behavior = new CharacterBehavior();
```

Usage
-----
Simply instanciate it and loop it until next() returns null
```PHP
while(($c = $behavior->next($stream_handle)) !== null)
{
	//Do something with $c
}
```