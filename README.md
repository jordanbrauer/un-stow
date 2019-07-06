# (Un)Stow

Offers a nice & powerful OOP and/or FP interface for PHP's `pack` and `unpack` functions.

## Install

Install with Composer

```bash
$ composer require jordanbrauer/un-stow
```

## Examples

Below are a few basic examples of how to use this library.

### Hello World

Simple "Hello World!" example for packing (`stow`) and unpacking (`unstow`) hexadecimal data.

```php
stow('48656C6C6F20576F726C6421')->hexNibbleHigh('*')->close();
# = (string) Hello World!

unstow('Hello World!')->hexNibbleHigh('*', 'hello_world')->open();
# = (array) [
#     'hello_world' => 48656C6C6F20576F726C6421,
# ],
```

### GIF Header

Even though we have other methods of checking for GIF image data now, this serves as a good example of how `unstow` works for unpacking binary data to read headers.

```php
$stream = fopen('./tests/Portal.gif', 'rb');
$bytes = fread($stream, 20);

fclose($stream);

$gifHeader = unstow($bytes)
    ->spacePaddedString(6, 'version')
    ->unsignedChar(2, 'width')
    ->unsignedChar(2, 'height')
    ->unsignedChar(1, 'flag')
    ->nullFill(11)
    ->unsignedChar(1, 'aspect')
    ->open();
```

### Reusing Packers

With this library you are able to create "template" packers and unpackers which have a predefined pattern and can accept arbitrary data to pack/unpack.

#### Object-Oriented Method

To re-use a packer in an OOP way, simply omit the bytes from your constructor and chain your format method calls to create your pattern. Next you can pass arbitrary data to the `load` method on and call `close`/`open` to process the data according to the format.

_E.g._,

```php
$packer = stow()
    ->unsignedShort('', Stow::BIG_ENDIAN_16_BIT)
    ->unsignedShort('', Stow::LITTLE_ENDIAN_16_BIT)
    ->signedChar('*');

echo $packer->load(0x1234, 0x5678, 65, 66)->close();
```

#### Functional Method

The functional method is quite similar to the object-oriented way, except two small differences.

1. After chaining all your format method calls, finish it off by calling the `standby` method.
    - This method will return a closure that accepts a set of variadic arguments of arbitrary data.
2. No need to call the `open`/`close` methods: the closure simply returns the packed/unpacked data!

_E.g._,

```php
$packer = stow()
    ->unsignedShort('', Stow::BIG_ENDIAN_16_BIT)
    ->unsignedShort('', Stow::LITTLE_ENDIAN_16_BIT)
    ->signedChar('*')
    ->standby();

echo $packer(0x1234, 0x5678, 65, 66);
```