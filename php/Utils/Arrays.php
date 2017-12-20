<?php

namespace Utils;

class Arrays
{
    /**
     * @var array $array
     */
    protected $array;

    /**
     * @param array $array
     */
    public function setArray(array $array): void
    {
        $this->array = $array;
    }

    /**
     * Given an array of integers and a desired sum,
     * return the first two occuring elements which could be added together to form the desired result.
     * @example Utils\Arrays::findPair(7, [1, 4, 5, 3, 6]) would return [4, 3] or [1, 6]
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
        call_user_func($sorting);

        return $this->array;
    }

    /**
     * Sort by quickSort algorithm
     * I use one function for start sorting and for recursion
     * @param int $left
     * @param int $right
     */
    private function quickSort(int $left = 0, int $right = 0): void
    {
        // Start sorting and prepare copy of variables
        $right == 0 && $right = count($this->array) - 1;
        $l = $left;
        $r = $right;
        // Calculate the 'center' (take the value of the central cell of the array)
        $center = $this->array[(int)($left + $right) / 2];
        do {
            while ($this->array[$l] < $center) $l++; // looking for values less than the 'center'
            while ($this->array[$r] > $center) $r--; // looking for values greater than the 'center'
            // after passing the cycles, check the cycle counters
            if ($l <= $r) {
                // and if the condition is true, then change the cells with each other
                $this->array[$l] > $this->array[$r] &&
                    list($this->array[$l], $this->array[$r]) = [$this->array[$r], $this->array[$l]];
                $l++;
                $r--;
            }
        } while ($l <= $r); // repeat the loop if true
        // if the condition is true than recursion; current start and end
        $l < $right && $this->quickSort($l, $right);
        // if the condition is true than recursion; initial start and current end
        $r > $left && $this->quickSort($left, $r);
    }

    /**
     * Sort by bubble sort algorithm
     */
    private function bubbleSort() {
        // array size minus 1
        $size = count($this->array) - 1;
        // bubble sorting
        for ($j = 0; $j < $size; $j++) {
            // iteration
            for ($i = 0; $i < ($size - $j); $i++) {
                // comparison
                if ($this->array[$i] > $this->array[$i + 1]) {
                    // swap
                    list($this->array[$i], $this->array[$i + 1]) = [$this->array[$i + 1], $this->array[$i]];
                }
            }
        }
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
