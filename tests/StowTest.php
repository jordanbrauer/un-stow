<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

final class Stowtest extends TestCase
{
    /**
     * Provides a closure that accepts a `Packable` and will return that
     * Packable, unclosed. Expected and actual data are also supplied for the
     * assertion method(s).
     *
     * @return Generator
     */
    public function formats(): Generator
    {
        yield from [
            'Unsigned Short 16bit Big Endian (), Unsigned Short 16bit Little Endian (), Signed Char (*)' => [
                function (Packable $packer): Packable {
                    return $packer->unsignedShort('', Stow::BIG_ENDIAN_16_BIT)
                        ->unsignedShort('', Stow::LITTLE_ENDIAN_16_BIT)
                        ->signedChar('*');
                },
                "\x124xVAB",
                0x1234, 0x5678, 65, 66,
            ],
            'Hex Nibble High (*)' => [
                function (Packable $packer): Packable {
                    return $packer->hexNibbleHigh('*');
                },
                'Hello World!',
                '48656C6C6F20576F726C6421',
            ],
        ];
    }

    /**
     * @dataProvider formats
     * @param Closure $format
     * @param mixed $expected
     * @param mixed[] ...$bytes
     * @return void
     */
    public function testPackingDataInVariousFormats(Closure $format, $expected, ...$bytes): void
    {
        $actual = $format(stow(...$bytes))->close();

        $this->assertSame($expected, $actual);
    }
}
