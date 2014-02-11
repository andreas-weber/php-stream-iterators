FileStreamIterator
==================
Give it a path to a file and it will open a file stream to it.
The path can be, in fact, any PHP wrapper!

Instanciation
-------------
Requires that you give him a valid path to a file you wish to open. Any wrapper is valid as this simply just passes the $content to the fopen() function for you and allows you to iterate it.

|Parameter|Expected content
|---------|----------------
|$content|A valid path to a resource that can be opened by fopen()
|[BehaviorInterface](https://github.com/crazycodr/php-stream-iterators/tree/master/docs/behaviors) $behavior|A behavior to apply to the stream on each iteration

```PHP
$iterator = new FileStreamIterator('/path/to/file', new BehaviorInterface());
$iterator = new FileStreamIterator('http://www.favoritesite.com/', new BehaviorInterface());
$iterator = new FileStreamIterator('ftp://user:pass@ftp.favoriteftp.com/foo/bar.txt', new BehaviorInterface());
```

Note that if the stream cannot be opened and read, the constructor will throw a: [\StandardExceptions\IOExceptions\FileNotReadableException](https://github.com/crazycodr/standard-exceptions/blob/master/src/StandardExceptions/IOExceptions/FileNotReadableException.php)

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