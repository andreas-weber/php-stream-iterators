Iterators
=========
Iterators initialize the stream wrapper used to read data from. They are simple iterators, nothing fancy, but they loop the stream ressource using standard PHP mechanisms and return the data until none left. Note that Iterators are just that, iterators of something else and they are used to initialize the stream per se.

Behaviors are the ones doing most of the job because they move and read the stream. Use [behaviors](../behaviors) to change the way the iterator returns your data.

You can always define new iterators by following the existing code base and by referring to the [interfaces documentation](../interfaces).

List of iterators
-----------------
1. [FileStreamIterator](FileStreamIterator.md)
2. [StringStreamIterator](StringStreamIterator.md)