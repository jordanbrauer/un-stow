<?php

declare(strict_types = 1);

interface Unpackable
{
    public function open(): array;

    // a	NUL-padded string
    // Z	NUL-padded string (Perl compatibilty mode?)
    public function nullPaddedString($repeater = '', string $key = ''): Unpackable;

    // A	SPACE-padded string
    public function spacePaddedString($repeater = '', string $key = ''): Unpackable;
    
    // h	Hex string, low nibble first
    public function hexNibbleLow($repeater = '', string $key = ''): Unpackable;
    
    // H	Hex string, high nibble first
    public function hexNibbleHigh($repeater = '', string $key = ''): Unpackable;

    // c	signed char
    public function signedChar($repeater = '', string $key = ''): Unpackable;

    // C	unsigned char
    public function unsignedChar($repeater = '', string $key = ''): Unpackable;
    
    // s	signed short (always 16 bit, machine byte order)
    public function signedShort($repeater = '', string $key = ''): Unpackable;
    
    // S	unsigned short (always 16 bit, machine byte order)
    // n	unsigned short (always 16 bit, big endian byte order)
    // v	unsigned short (always 16 bit, little endian byte order)
    public function unsignedShort($repeater = '', string $key = '', int $order): Unpackable;
    
    // i	signed integer (machine dependent size and byte order)
    public function signedInteger($repeater = '', string $key = ''): Unpackable;
    
    // I	unsigned integer (machine dependent size and byte order)
    public function unsignedInteger($repeater = '', string $key = ''): Unpackable;

    // l	signed long (always 32 bit, machine byte order)
    public function signedLong($repeater = '', string $key = ''): Unpackable;
    
    // L	unsigned long (always 32 bit, machine byte order)
    // N	unsigned long (always 32 bit, big endian byte order)
    // V	unsigned long (always 32 bit, little endian byte order)
    public function unsignedLong($repeater = '', string $key = '', int $order): Unpackable;

    // q	signed long long (always 64 bit, machine byte order)
    public function signedLongLong($repeater = '', string $key = ''): Unpackable;

    // Q	unsigned long long (always 64 bit, machine byte order)
    // J	unsigned long long (always 64 bit, big endian byte order)
    // P	unsigned long long (always 64 bit, little endian byte order)
    public function unsignedLongLong($repeater = '', string $key = '', int $order): Unpackable;
    
    // f	float (machine dependent size and representation)
    // g	float (machine dependent size, little endian byte order)
    // G	float (machine dependent size, big endian byte order)
    public function float($repeater = '', string $key = '', int $order): Unpackable;
    
    // d	double (machine dependent size and representation)
    // e	double (machine dependent size, little endian byte order)
    // E	double (machine dependent size, big endian byte order)
    public function double($repeater = '', string $key = '', int $order): Unpackable;

    // x	NUL byte
    public function null($repeater = '', string $key = ''): Unpackable;
    
    // X	Back up one byte
    public function backup($repeater = '', string $key = ''): Unpackable;
    
    // @	NUL-fill to absolute position
    public function nullFill($repeater = '', string $key = ''): Unpackable;
}