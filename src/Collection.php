<?php

namespace ArsalanThange\Collections;

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
     * Filter collection based on user given parameters.
     *
     * @param string $key       Key of the collection on which the filter is to be performed.
     * @param string $operation Operation based on which the collection is to be filtered.
     * @param string $value     Value on which the filter is to be performed.
     * @return static
     */
    public function where($key, $operation, $value)
    {
        $this->array = array_filter($this->array, function ($elem) use ($key, $operation, $value) {

            if (is_object($elem)) {
                $val = $elem->$key;
            } else {
                $val = $elem[$key];
            }

            switch ($operation) {
                case "=":
                    return $val == $value;
                case "!=":
                    return $val != $value;
                case ">=":
                    return $val >= $value;
                case "<=":
                    return $val <= $value;
                case ">":
                    return $val > $value;
                case "<":
                    return $val < $value;
                default:
                    return true;
            }
        });

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
        $total = count($this->array);
        $total_pages = ceil($total / $count);
        $page = $page > $total_pages ? $total_pages : $page;
        $current_page = $page;
        $offset = max(0, ($page - 1) * $count);
        $from = $offset + 1;
        $to = $offset + $count;
        $data = array_slice($this->array, $offset, $count, true);

        $response = [
            'total' => $total,
            'current_page' => $page,
            'total_pages' => $total_pages,
            'from' => $from,
            'to' => $to,
            'data' => $data,
        ];
        
        return $response;
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

    /**
     * Returns value at the specified key. Returns null if the key doesnt exist and no default value is specified.
     *
     * @param string $key           Key whose value is to be returned
     * @param mixed $default_value  If the key does not exist, return the default value.
     * @return mixed
     */
    public function get($key, $default_value = null)
    {
        if (isset($this->array[$key])) {
            return $this->array[$key];
        }

        return $default_value;
    }

    /**
     * Sums the values in the given collection.
     * Only sums the numerical values, any non-numerical values will be not disregarded.
     *
     * @return int
     */
    public function sum()
    {
        return array_sum($this->array);
    }
}
