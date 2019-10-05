<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

final class Unstowtest extends TestCase
{
    /**
     * Provides a closure that accepts an `Unpackable` and will return that
     * instance, unopened. Expected and actual data are also supplied for the
     * assertion method(s).
     *
     * @return Generator
     */
    public function formats(): Generator
    {
        $stream = function (string $path, string $mode, int $read) {
            $stream = fopen($path, $mode);
            $bytes = fread($stream, $read);

            fclose($stream);

            return $bytes;
        };

        yield from [
            'GIF image header' => [
                function (Unpackable $unpacker): Unpackable {
                    return $unpacker->spacePaddedString(6, 'version')
                        ->unsignedChar(2, 'width')
                        ->unsignedChar(2, 'height')
                        ->unsignedChar(1, 'flag')
                        ->nullFill(11)
                        ->unsignedChar(1, 'aspect');
                }, [
                    "version" => "GIF89a",
                    "width1"  => 135,
                    "width2"  => 0,
                    "height1" => 180,
                    "height2" => 0,
                    "flag"    => 212,
                    "aspect"  => 0,
                ],
                $stream('./tests/Portal.gif', 'rb', 20),
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
    public function testUnpackingDataInVariousFormats(Closure $format, $expected, ...$bytes): void
    {
        $actual = $format(unstow(...$bytes))->open();

        $this->assertInternalType('array', $actual);
        $this->assertSame($expected, $actual);
    }
}
