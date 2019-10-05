<?php

declare(strict_types = 1);

/**
 * Object oriented wraper for the PHP `pack` function, constructable via function.
 *
 * @param mixed ...$bytes
 * @return Packable
 */
function stow(...$bytes): Packable
{
    return new \Stow(...$bytes);
}

/**
 * Object oriented wraper for the PHP `unpack` function, constructable via function.
 *
 * @param mixed ...$bytes
 * @return Unpackable
 */
function unstow(...$bytes): Unpackable
{
    return new \Unstow(...$bytes);
}
