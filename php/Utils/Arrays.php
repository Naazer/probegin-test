<?php

namespace Utils;

class Arrays
{
    /**
     * @var array $array
     */
    protected $array;

    /**
     * Given an array of integers and a desired sum,
     * return the first two occuring elements which could be added together to form the desired result.
     * @example Utils\Array::findPair(7, [1, 4, 5, 3, 6]) would return [4, 3] or [1, 6]
     *
     * @param  int   $sum  Desired sum
     * @return array|bool Array of mathing elements or FALSE
     * @throws \DomainException
     */
    public function findPair(int $sum)
    {
        $result = [];
        for ($i = 0; $i < count($this->array); $i++) {
			if(is_numeric($this->array[$i])) { // element is not a number and cannot be cast to a number
				throw new \DomainException(sprintf('A[%d] is not a number: %s', $i, typeof($this->array[$i])));
			}

            $result[] = $this->array[$i]; // assume first sum element
            $match = $sum - $this->array[$i];
            for ($j = $i+1; $j < count($this->array); $j++) {
                if ($this->array[$j] == $match) { // found second element of the pair, return result
                    $result[] = $match;
                    return $result;
                }
            }
        }
        // no pairs found
        return false;
    }

    /**
     * Setter method for the internal array
     * @param array $data
     * @return $this
     */
    public function setValue(array $data)
    {
        $this->array = $data;
        $this->checkArray();
        return $this;
    }


    /**
     * Throws an exception if array consists of not only numbers, or some of them are not whole
     * @throws \DomainException
     */
    private function checkArray()
    {
        foreach ($this->array as $key => $element) {
            if (!is_numeric($element)) {
                throw new \DomainException(sprintf('Element array #%d is not a number', $key));
            }
            if (intval($element) != $element) {
                throw new \DomainException(sprintf('Element array #%d is not an integer', $key));
            }
        }
    }

    /**
     * Sort by custom function
     *
     * @param  callable $sorting Function providing an algorythm
     * @return array Sorted array
     * @throws \DomainException
     */
    public function sortBy(callable $sorting): array
    {
        // @TODO: create body of the function and cover with tests
    }

    /**
     * Sort by key length
     *
     * @return array Sorted array
     */
    public function sortByKeyLength(): array
    {
        // @TODO: create body of the function and cover with tests
    }
}
