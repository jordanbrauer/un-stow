<?php

declare(strict_types = 1);

final class Unstow extends BinaryDataFormat implements Unpackable
{
    protected const SEPARATOR = '/';

    /**
     * Format and pack the data according to the constructed format, returning
     * the final binary string.
     *
     * @return array
     */
    public function open(int $offset = 0): array
    {   
        return unpack((string) $this, ...$this->bytes, ...[$offset]);
    }

    public function nullPaddedString($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('a', $repeater, $key);
    }

    public function spacePaddedString($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('A', $repeater, $key);
    }

    public function hexNibbleLow($repeater = '', string $key = ''): Unpackable
    {   
        return $this->format('h', $repeater, $key);
    }
    
    public function hexNibbleHigh($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('H', $repeater, $key);
    }

    public function signedChar($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('c', $repeater, $key);
    }

    public function unsignedChar($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('C', $repeater, $key);
    }
    
    public function signedShort($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('s', $repeater, $key);
    }
    
    public function unsignedShort($repeater = '', string $key = '', int $order): Unpackable
    {
        $code = self::$codesUnsignedShort[$order] ?? null;

        if (!$code) {
            throw new \InvalidArgumentException('Invalid argument for $order: '.$order);
        }
        
        return $this->format($code, $repeater, $key);
    }
    
    public function signedInteger($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('i', $repeater, $key);
    }
    
    public function unsignedInteger($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('I', $repeater, $key);
    }

    public function signedLong($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('l', $repeater, $key);
    }

    public function unsignedLong($repeater = '', string $key = '', int $order): Unpackable
    {
        return $this->format(
            $this->codeFromByteOrderOrThrow($order, self::$codesUnsignedLong),
            $repeater
        );
    }

    public function signedLongLong($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('q', $repeater, $key);
    }

    public function unsignedLongLong($repeater = '', string $key = '', int $order): Unpackable
    {
        $code = self::$codesUnsignedLongLong[$order] ?? null;

        if (!$code) {
            throw new \InvalidArgumentException('Invalid argument for $order: '.$order);
        }
        
        return $this->format($code, $repeater, $key);
    }

    public function float($repeater = '', string $key = '', int $order): Unpackable
    {
        $code = self::$codesFloat[$order] ?? null;

        if (!$code) {
            throw new \InvalidArgumentException('Invalid argument for $order: '.$order);
        }

        return $this->format($code, $repeater, $key);
    }

    public function double($repeater = '', string $key = '', int $order): Unpackable
    {
        $code = self::$codesDouble[$order] ?? null;

        if (!$code) {
            throw new \InvalidArgumentException('Invalid argument for $order: '.$order);
        }

        return $this->format($code, $repeater, $key);
    }

    public function null($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('x', $repeater, $key);
    }
    
    public function backup($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('X', $repeater, $key);
    }
    
    public function nullFill($repeater = '', string $key = ''): Unpackable
    {
        return $this->format('@', $repeater, $key);
    }
}