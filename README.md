# PHP Currency Formatter
PHP Lib for formatting currencies. 

## Why make this?
Many of the Currency Formatters I found relied on locales. My current needs for a formatter required the decoupling of locale knowledge.

## Installation
```sh
composer require axm/currency-formatter
```

## Usage
The formatter is powered by the Currency Collection which holds an array of formatting rules. You can create your own collection and then set it to the Formatter:

```php
$settings = [
	'currency_symbol' => '$',
	'decimal_spaces' => 2,
	'decimal_separator' => '.',
	'thousand_separator' => ','
];

$config = new Config('USD', $settings);

$collection = new Collection();
$collection->push($config);

Formatter::setCollection($collection);
echo Formatter::format('1234.56', 'USD'); // $1,234.56 USD
```
The above seperates the Config, Collection and Formatter classes for maximum flexibility. It allows you to define your own sets of rules and only load the rules you actually need for a minor performance boost.

However, The above seems like a bit of setup. This is where the Loader class comes in:

```php
/*
Given a JSON string of currency settings:
[
  {
    "iso_code": "USD",
    "currency_symbol": "$",
    "decimal_spaces": 2,
    "decimal_separator": ".",
    "thousand_separator": ",",
	 "label": "Dollars"
  },
  {
    "iso_code": "GBP",
    "currency_symbol": "£",
    "decimal_spaces": 2,
    "decimal_separator": ",",
    "thousand_separator": ".",
	 "label": null // if omitted will use the iso_code
  },
  {
    "iso_code": "CLP",
    "currency_symbol": "$",
    "decimal_spaces": 0,
    "decimal_separator": ",",
    "thousand_separator": "."
  }
]
*/

$settings = json_decode(file_get_contents(json_file));
Loader::fromArray(settings);

// Your Format class now has a collection with 3 currency rules
echo Format::(1234.56, 'USD'); // $1,234.56 Dollars
echo Format::(1234.56, 'GBP'); // £1.234,56 GBP
echo Format::(1234.56, 'CLP'); // $1.235 CLP
```
So long as you have an array in the expected format, using the Loader is the best way to go.

## Customizing the output
If you wish to more granular control you can either create your own set of rules or override the exisitng ones like so:

```php
//creating a custom rule
Formatter::getCollection()->push([
	'iso_code' => 'USD2',
	'currency_symbol' => '',
	'decimal_spaces' => 2,
	'decimal_separator' => '.',
	'thousand_separator' => ',',
	'label' => ' big ones'
]);
Formatter::format(1234.56, 'USD2'); // 1,234.56 big ones

//overriding an existing rule
echo Format::(1234.56, 'USD2', [
	'currency_symbol' => '$$ ',
	'decimal_spaces' => 4,
	'label' => 'bucks'
]); // $$ 1,234.5600 big ones
```

## Tests
The library uses Kahlan for testing. To run tests make suer you have the require-dev modules installed:
```sh
composer install
./bin/kahlan
```

## License

MIT License

Copyright (c) 2016 
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.