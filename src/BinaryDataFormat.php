<?php

declare(strict_types = 1);

abstract class BinaryDataFormat implements ArrayAccess, Countable, IteratorAggregate
{   
    public const BIG_ENDIAN_16_BIT = 1;
    
    public const BIG_ENDIAN_32_BIT = 4;
    
    public const BIG_ENDIAN_64_BIT = 7;

    public const BIG_ENDIAN_MACHINE_DEPENDENT = 10;

    public const LITTLE_ENDIAN_16_BIT = 2;
    
    public const LITTLE_ENDIAN_32_BIT = 5;
    
    public const LITTLE_ENDIAN_64_BIT = 8;

    public const LITTLE_ENDIAN_MACHINE_DEPENDENT = 11;
    
    public const MACHINE_ORDER_16_BIT = 0;

    public const MACHINE_ORDER_32_BIT = 3;

    public const MACHINE_ORDER_64_BIT = 6;

    public const MACHINE_ORDER_AND_REPRESENTATION = 9;

    protected const SEPARATOR = '';

    protected static $codesUnsignedShort = [
        self::MACHINE_ORDER_16_BIT => 'S',
        self::BIG_ENDIAN_16_BIT => 'n',
        self::LITTLE_ENDIAN_16_BIT => 'v',
    ];

    protected static $codesUnsignedLong = [
        self::MACHINE_ORDER_32_BIT => 'L',
        self::BIG_ENDIAN_32_BIT => 'N',
        self::LITTLE_ENDIAN_32_BIT => 'V',
    ];

    protected static $codesUnsignedLongLong = [
        self::MACHINE_ORDER_64_BIT => 'Q',
        self::BIG_ENDIAN_64_BIT => 'J',
        self::LITTLE_ENDIAN_64_BIT => 'P',
    ];

    protected static $codesFloat = [
        self::MACHINE_ORDER_AND_REPRESENTATION => 'f',
        self::LITTLE_ENDIAN_MACHINE_DEPENDENT => 'g',
        self::BIG_ENDIAN_MACHINE_DEPENDENT => 'G',
    ];

    protected static $codesDouble = [
        self::MACHINE_ORDER_AND_REPRESENTATION => 'd',
        self::LITTLE_ENDIAN_MACHINE_DEPENDENT => 'e',
        self::BIG_ENDIAN_MACHINE_DEPENDENT => 'E',
    ];

    protected $format = [];

    protected $bytes;
    
    public function __construct(...$bytes)
    {
        $this->bytes = $bytes;
    }

    public function __toString(): string
    {
        return implode(static::SEPARATOR, $this->format);
    }

    public function load(...$bytes): Packable
    {
        $this->bytes = $bytes;
        
        return $this;
    }

    public function standby(): Closure
    {
        return function (...$bytes): string {
            return $this->load(...$bytes)->close();
        };

        // return fn (): string => $this->close();
    }

    public function reset(...$bytes): void
    {
        $this->format = [];
    }

    /**
     * Determine if a byte exists at the given offset.
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->bytes);
    }

    /**
     * Get a byte at the given offset.
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->bytes[$offset];
    }

    /**
     * Set a byte at the given offset.
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->bytes[] = $value;

            return;
        }
        
        $this->bytes[$offset] = $value;
    }

    /**
     * Unset a byte at the given offset.
     *
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->byte[$offset]);
    }
    
    /**
     * Return a count of the bytes in the current instance of stow.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->bytes);
    }

    /**
     * Retrieve an external iterator with the currently stowed bytes as it's
     * items.
     *
     * @throws Exception
     * @return Traversable|Iterator|Generator
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->bytes);
    }

    protected function codeFromByteOrderOrThrow(int $order, array $codes): string
    {
        $code = $codes[$order] ?? null;

        if (!$code) {
            throw new \InvalidArgumentException('Invalid argument for $order: '.$order);
        }
        
        return $code;
    }

    protected function format(string $code, $repeater, string $key = ''): self
    {
        $isString = is_string($repeater);
        $isNumeric = is_numeric($repeater);
        
        if (!($isString and $isNumeric) and !$isNumeric and '*' !== $repeater and !empty($repeater)) {
            throw new \InvalidArgumentException('Invalid argument for $repeater: '.$repeater);
        }

        if ($isString) {
            $repeater = trim($repeater);
        }

        if ($isNumeric) {
            $repeater = (string) ((int) $repeater);
        }
        
        $this->format[] = trim($code).$repeater.trim($key);
        
        return $this;
    }
}