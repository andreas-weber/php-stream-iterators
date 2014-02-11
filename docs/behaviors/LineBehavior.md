LineBehavior
============
The line behavior returns a single line without the \r and/or \n that triggered it. Note that any combination of \r\n or \n\r will trigger line behavior.

Instanciation
-------------
```PHP
//There are no configuration settings for this behavior
$behavior = new LineBehavior();
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