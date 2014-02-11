MemoryStreamIterator
==================
Give it a variable and it will use this variable as the content to stream on.

Instanciation
-------------
Requires that you give it a string variable to work on and opens a memory stream that the data is pushed into.

|Parameter|Expected content
|---------|----------------
|$content|A valid string variable to be pushed into the opened memory stream
|[BehaviorInterface](https://github.com/crazycodr/php-stream-iterators/tree/master/docs/behaviors) $behavior|A behavior to apply to the stream on each iteration

```PHP
$iterator = new MemoryStreamIterator($string_variable, new BehaviorInterface());
```

Note that only strings are accepted. If the initial value is not a string, the constructor will throw a: [\StandardExceptions\LogicExceptions\IllegalArgumentTypeException](https://github.com/crazycodr/standard-exceptions/blob/master/src/StandardExceptions/LogicExceptions/IllegalArgumentTypeException.php)

_This exception comes from the **[crazycodr/standard-exceptions](https://github.com/crazycodr/standard-exceptions)** package_

Usage
-----
Once initialized, simply iterate it!
```PHP
foreach($iterator as $value)
{
	//Do something with $value
}
```