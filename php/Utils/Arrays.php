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
		if($sum <= 0) {
			throw new \DomainException('Sum must be > 0');
		}
		$result = [];
		for($i = 0; $i < length($this->array); $i++)
		{
			if($this->array[$i] > $sum) {
				continue;
			}

			$result[] = $this->array[$i];
			$match = $sum = $this->array[$i];
			for($j = $i; $i < length($this->array); $j++)
			{
				if($this->array[$j] == $match) {
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
		return $this;
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
