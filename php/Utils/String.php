<?php

namespace Utils;

class String
{
    /**
     * @var string $string
     */
    protected $string;

    /**
     * Change case of a given string to kebeb
     *
     * @example this-is-kebab-case
     * @return string Kebab-cased string
     * @throws \DomainException
     */
    public function kebabCase(): string
    {
        // @TODO: implement body and cover with tests
    }

    /**
     * Count char occurences in the given string
     *
     * @param  string $char Needle
     * @return int Count of occurence
     * @throws \InvalidArgumentException
     */
    public function countCharsOccurence(string $char): int
    {
        // @TODO: implement body and cover with tests
    }

    /**
     * Get char that most frequentlly occurs in the given string
     *
     * @param  string $char Needle
     * @return string Char
     * @throws \InvalidArgumentException
     */
    public function mostFrequentChars(string $char): string
    {
        // @TODO: implement body and cover with tests
    }

    /**
     * Get first unique (or less occured) char for the given string
     *
     * @return string Char
     */
    public function firstUniqueChar(): string
    {
        // @TODO: implement body and cover with tests
        // Note: upper- and lowercase letters are considered the same character,
        // but the function should return the correct case for the initial letter
    }

    /**
     * Get a compressed string
     *
     * @example
     * <code>
     *   aaa       -> a3
     *   apple     -> a1e1p2
     *   apple pie -> a1e2i1l1p3
     * </code>
     * @return string
     */
    public function asciiCompression(): string
    {
        // @TODO: implement body and cover with tests
    }

    /**
     * Is given string a heterogram
     *
     * @return bool
     */
    public function isHeterogram(): bool
    {
        // @TODO: implement body and cover with tests
    }

}
