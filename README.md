## About PHP Collections

This library converts your arrays into Collections. It comes with various built in functions to manipulate and work with arrays. The class is immutable, meaning every Collection method you execute will return an entirely new Collection instance.

## Usage

#### Converting Array into Collection
```php
// Array which is to be converted to a Collection
$array = [5, 'a', 't', 2, 7];

$collection = new Collection($array);
```

#### Sorting the Collection
```php
//Sort in Ascending Order
$collection->sort()->all();

//Output: ['a', 't', 2, 5, 7]

//Sort in Descending Order
$collection->sort('DESC')->all();

//Output: [7, 5, 2, 't', 'a']
```

#### Paginate the Collection
Note: This is currently not a length aware pagination.
The `paginate` method accepts 2 parameters.
```php
$array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

$collection = new Collection($array);

//Page number
$page = 1;

//Number of elements to be displayed on the page
$count = 4

//Paginate the collection
$collection->paginate($page, $count)->all();

//Output: [1, 2, 3, 4]
```

If you require elements on the next page simply increment the page value.
Note: The `paginate` method should run on the initial collection for page increments and not on the newly returned instance.

#### Filter the Collection
Filtering works on all the basic operations such as `=`, `!=`, `>`, `<`, `>=` and `<=`.
```php
$array = [
    ['apples' => 5, 'bananas' => 3, 'oranges' => 2],
    ['apples' => 10, 'bananas' => 5, 'oranges' => 1],
    ['apples' => 15, 'bananas' => 10, 'oranges' => 6]
];

$collection = new Collection($array);

//Filter the collection
$collection->where('apples', '>', 5)->all();

/*
Output: [
    ['apples' => 10, 'bananas' => 5, 'oranges' => 1],
    ['apples' => 15, 'bananas' => 10, 'oranges' => 6]
]
*/
```
You can chain the `where` method to apply multiple filters.
```php
//Filter the collection
$collection->where('apples', '>', 5)->where('bananas', '=', 10)->all();

/*
Output: [
    ['apples' => 15, 'bananas' => 10, 'oranges' => 6]
]
*/
```

#### Count the number of elements in the Collection
```php
$array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

$collection = new Collection($array);

//Count the number of elements
$collection->count();

//Output: 10
```

#### Reset Array keys
The `values` method resets your array keys.
```php
$array = [
    'first_basket' => ['apples' => 5, 'bananas' => 3, 'oranges' => 2],
    'second_basket' => ['apples' => 10, 'bananas' => 5, 'oranges' => 1],
    'third_basket' => ['apples' => 15, 'bananas' => 10, 'oranges' => 6]
];

$collection = new Collection($array);

$collection->values()->all();

/*Output: [
    ['apples' => 5, 'bananas' => 3, 'oranges' => 2],
    ['apples' => 10, 'bananas' => 5, 'oranges' => 1],
    ['apples' => 15, 'bananas' => 10, 'oranges' => 6]
]
*/
```

#### Get value of a specified key
The `get` method returns the value of the specified key. Returns `null` if the key does not exist and if no default value is specified.
```php
$array = [
    'first_basket' => ['apples' => 5, 'bananas' => 3, 'oranges' => 2],
    'second_basket' => ['apples' => 10, 'bananas' => 5, 'oranges' => 1],
    'third_basket' => ['apples' => 15, 'bananas' => 10, 'oranges' => 6]
];

$collection = new Collection($array);

$collection->get('first_basket');

// Output: ['apples' => 5, 'bananas' => 3, 'oranges' => 2]

$collection->get('fourth_basket');

// Output: null

//Second parameter is the default value if the key does not exist
$collection->get('fourth_basket', 'No fruits here!');

// Output: No fruits here!

```