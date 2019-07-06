<?php

declare(strict_types = 1);

interface Packable
{
    /**
     * Format and pack the data according to the constructed format, returning
     * the final binary string.
     *
     * @return string
     */
    public function close(): string;

    // a	NUL-padded string
    // Z	NUL-padded string (Perl compatibilty mode?)
    public function nullPaddedString($repeater = ''): Packable;

    // A	SPACE-padded string
    public function spacePaddedString($repeater = ''): Packable;
    
    // h	Hex string, low nibble first
    public function hexNibbleLow($repeater = ''): Packable;

    /**
     * Process a hex string, high nibble first.
     *
     * @param string $repeater A valid repeater argument for the format code.
     * @return Packable
     */
    public function hexNibbleHigh($repeater = ''): Packable;

    // c	signed char
    public function signedChar($repeater = ''): Packable;

    // C	unsigned char
    public function unsignedChar($repeater = ''): Packable;
    
    // s	signed short (always 16 bit, machine byte order)
    public function signedShort($repeater = ''): Packable;
    
    // S	unsigned short (always 16 bit, machine byte order)
    // n	unsigned short (always 16 bit, big endian byte order)
    // v	unsigned short (always 16 bit, little endian byte order)
    public function unsignedShort($repeater = '', int $order): Packable;
    
    // i	signed integer (machine dependent size and byte order)
    public function signedInteger($repeater = ''): Packable;
    
    // I	unsigned integer (machine dependent size and byte order)
    public function unsignedInteger($repeater = ''): Packable;

    // l	signed long (always 32 bit, machine byte order)
    public function signedLong($repeater = ''): Packable;
    
    // L	unsigned long (always 32 bit, machine byte order)
    // N	unsigned long (always 32 bit, big endian byte order)
    // V	unsigned long (always 32 bit, little endian byte order)
    public function unsignedLong($repeater = '', int $order): Packable;

    // q	signed long long (always 64 bit, machine byte order)
    public function signedLongLong($repeater = ''): Packable;

    // Q	unsigned long long (always 64 bit, machine byte order)
    // J	unsigned long long (always 64 bit, big endian byte order)
    // P	unsigned long long (always 64 bit, little endian byte order)
    public function unsignedLongLong($repeater = '', int $order): Packable;
    
    // f	float (machine dependent size and representation)
    // g	float (machine dependent size, little endian byte order)
    // G	float (machine dependent size, big endian byte order)
    public function float($repeater = '', int $order): Packable;
    
    // d	double (machine dependent size and representation)
    // e	double (machine dependent size, little endian byte order)
    // E	double (machine dependent size, big endian byte order)
    public function double($repeater = '', int $order): Packable;

    // x	NUL byte
    public function null($repeater = ''): Packable;
    
    // X	Back up one byte
    public function backup($repeater = ''): Packable;
    
    // @	NUL-fill to absolute position
    public function nullFill($repeater = ''): Packable;
}