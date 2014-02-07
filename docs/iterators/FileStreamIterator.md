FileStreamIterator
==================
Give it a path to a file and it will open a file stream to it.

```PHP
$iterator = new FileStreamIterator('/path/to/file', new BehaviorInterface());
$iterator = new FileStreamIterator('http://www.favoritesite.com/', new BehaviorInterface());
$iterator = new FileStreamIterator('ftp://user:pass@ftp.favoriteftp.com/foo/bar.txt', new BehaviorInterface());
```

Note that if the stream cannot be opened and read, the constructor will throw a:

[\StandardExceptions\IOExceptions\FileNotReadableException](https://github.com/crazycodr/standard-exceptions/blob/master/src/StandardExceptions/IOExceptions/FileNotReadableException.php)

_This exception comes from the **crazycodr/standard-exceptions** package_