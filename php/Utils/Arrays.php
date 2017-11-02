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
        // @TODO: create body of the function and cover with tests
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
