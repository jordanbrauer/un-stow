<?php

declare(strict_types = 1);

final class Stow extends BinaryDataFormat implements Packable
{
    public function backup($repeater = ''): Packable
    {
        return $this->format('X', $repeater);
    }

    /**
     * Format and pack the data according to the constructed format, returning
     * the final binary string.
     *
     * @return string
     */
    public function close(): string
    {
        return pack((string) $this, ...$this->bytes);
    }

    public function double($repeater = '', int $order): Packable
    {
        $code = self::$codesDouble[$order] ?? null;

        if (!$code) {
            throw new \InvalidArgumentException('Invalid argument for $order: '.$order);
        }

        return $this->format($code, $repeater);
    }

    public function float($repeater = '', int $order): Packable
    {
        $code = self::$codesFloat[$order] ?? null;

        if (!$code) {
            throw new \InvalidArgumentException('Invalid argument for $order: '.$order);
        }

        return $this->format($code, $repeater);
    }

    public function hexNibbleHigh($repeater = ''): Packable
    {
        return $this->format('H', $repeater);
    }

    public function hexNibbleLow($repeater = ''): Packable
    {
        return $this->format('h', $repeater);
    }

    public function null($repeater = ''): Packable
    {
        return $this->format('x', $repeater);
    }

    public function nullFill($repeater = ''): Packable
    {
        return $this->format('@', $repeater);
    }

    public function nullPaddedString($repeater = ''): Packable
    {
        return $this->format('a', $repeater);
    }

    public function signedChar($repeater = ''): Packable
    {
        return $this->format('c', $repeater);
    }

    public function signedInteger($repeater = ''): Packable
    {
        return $this->format('i', $repeater);
    }

    public function signedLong($repeater = ''): Packable
    {
        return $this->format('l', $repeater);
    }

    public function signedLongLong($repeater = ''): Packable
    {
        return $this->format('q', $repeater);
    }

    public function signedShort($repeater = ''): Packable
    {
        return $this->format('s', $repeater);
    }

    public function spacePaddedString($repeater = ''): Packable
    {
        return $this->format('A', $repeater);
    }

    public function unsignedChar($repeater = ''): Packable
    {
        return $this->format('C', $repeater);
    }

    public function unsignedInteger($repeater = ''): Packable
    {
        return $this->format('I', $repeater);
    }

    public function unsignedLong($repeater = '', int $order): Packable
    {
        return $this->format(
            $this->codeFromByteOrderOrThrow($order, self::$codesUnsignedLong),
            $repeater
        );
    }

    public function unsignedLongLong($repeater = '', int $order): Packable
    {
        $code = self::$codesUnsignedLongLong[$order] ?? null;

        if (!$code) {
            throw new \InvalidArgumentException('Invalid argument for $order: '.$order);
        }

        return $this->format($code, $repeater);
    }

    public function unsignedShort($repeater = '', int $order): Packable
    {
        $code = self::$codesUnsignedShort[$order] ?? null;

        if (!$code) {
            throw new \InvalidArgumentException('Invalid argument for $order: '.$order);
        }

        return $this->format($code, $repeater);
    }
}
