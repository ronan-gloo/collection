# Collection Library


### Searching

```
$collection = new Collection(['one', 'two']);

// search by element: true
$collection->contains('one');

// search by key: true
$collection->has(1);

// find the first index of the given element.
$collection->indexOf('one');

// get a Collection instance for all indexes of the given element
$collection->indexesOf('one');

```

### Map | Reduce

The method reduce() can return any kind of value.

```
$collection = new Collection([1, 2, 3]);
$result = $collection
	->map(function($item) {
        return $item * 2;
    })
    ->reduce(function($carry, $item) {
        return $item + $carry;
    });
    
echo $result; // 12
```



### Filter / Reject

Filter accepts any valid callback 

```
// creates new collection with only string elements found in $collection
$filtered = $collection->filter('is_string');

// creates new collection with only string keys found in $collection
$filtered = $collection->filter('is_string', Collection::FILTER_KEY);

// Same as above, but reject all string keys
$filtered = $collection->reject('is_string', Collection::FILTER_KEY);

```

### Mutable Interface

Various operations that change the collection state

$collection = new MutableCollection;

```
// set / unset key
$collection->set('key', 'value');
$collection->delete('key');

// Push element
$collection->add('value');

// remove all elements 'value'
$collection->remove('value');

// replace every occurrences of the element by a new one
$collection->replace('element', 'new one');

// Clear all collection elements
$collection->clear();

```