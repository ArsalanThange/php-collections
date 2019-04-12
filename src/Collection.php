<?php

namespace ArsalanThange\PHPCollection;

class Collection implements \Countable
{
    /**
     * Array which is to be converted to a collection.
     *
     * @var array
     */
    protected $array = [];

    /**
     * Prepare array to be made into Collection.
     *
     * @param array $array
     * @return void
     */
    public function __construct($array = [])
    {
        $this->array = $this->makeCollection($array);
    }

    /**
     * Returns incoming array. This method needs more working.
     *
     * @param array $array
     * @return array
     */
    public function makeCollection($array)
    {
        return (array) $array;
    }

    /**
     * Returns all of the items in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->array;
    }

    /**
     * Return only values and resets keys of the collection.
     *
     * @return static
     */
    public function values()
    {
        return new static(array_values($this->array));
    }

    /**
     * Returns a sorted collection.
     *
     * @param string $operation ASC/DESC operation to sort the collection in Ascending or Descending order
     * @return static
     */
    public function sort($operation = 'ASC')
    {
        $operation == 'ASC' ? asort($this->array) : rsort($this->array);

        return new static($this->array);
    }

    /**
     * Paginates the collection.
     *
     * @param int $page     Page number.
     * @param int $count    Count of collection items to be displayed per page.
     * @return static
     */
    public function paginate($page = 1, $count = 10)
    {
        $offset = max(0, ($page - 1) * $count);

        return new static(array_slice($this->array, $offset, $count, true));
    }

    /**
     * Returns the count of total number of items in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->array);
    }
}
