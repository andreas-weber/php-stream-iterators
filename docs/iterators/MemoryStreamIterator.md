MemoryStreamIterator
====================
Give it a variable and it will use this variable as the content to stream on.

```PHP
$iterator = new StringStreamIterator($longstring, new BehaviorInterface());
```

Note that only strings are accepted. If the initial value is not a string, the constructor will throw a:

[\StandardExceptions\LogicExceptions\IllegalArgumentTypeException](https://github.com/crazycodr/standard-exceptions/blob/master/src/StandardExceptions/LogicExceptions/IllegalArgumentTypeException.php)

_This exception comes from the **crazycodr/standard-exceptions** package_