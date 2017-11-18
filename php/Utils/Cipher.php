<?php

namespace Utils;

interface Cipher
{
    /**
     * Encode the string
     *
     * @param  string $string Input
     * @return string Encoded string
     * @throws \LogicException
     */
    public static function encode(string $string): string;

    /**
     * Decode the ciphered string
     *
     * @param  string $string Encoded value
     * @return string Decoded string
     * @throws \LogicException
     */
    public static function decode(string: $string): string;

}
