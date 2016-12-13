<?php
namespace Axm\Currency;

use Axm\Tests\Helpers\ReflectionHelper;

describe(Formatter::class, function () {
    beforeEach(function () {
        $formatter = Formatter::class;
        $this->collection = new Collection;
        $this->data = [];

        $json = file_get_contents(FACADES_DIR . 'currency_configs.json');
        $data = json_decode($json, true);

        foreach ($data as $settings) {
            $iso_code = $settings['iso_code'];
            $this->data[$iso_code] = $settings;
            $this->collection->push(new Config($iso_code, $settings));
        }
        $formatter::setCollection($this->collection);

        $this->formatter = $formatter;
    });
    describe('setCollection', function () {
        it('sets a ' . Collection::class, function () {
            $actual = ReflectionHelper::getStaticPropertyValue($this->formatter, 'collection');
            expect($actual)->toBe($this->collection);
        });
    });

    describe('format', function () {
        it('formats a string into a currency string', function () {
            /** @var Formatter $formatter */
            $formatter = $this->formatter;

            $actual = $formatter::format('1234.56');
            $expected = '$1,234.56 USD';

            expect($actual)->toBe($expected);
        });

        it('formats a number into a currency string', function () {
            /** @var Formatter $formatter */
            $formatter = $this->formatter;

            $actual = $formatter::format(1234.56);
            $expected = '$1,234.56 USD';

            expect($actual)->toBe($expected);
        });

        it('formats according to the ' . Config::class . ' loaded', function () {
            /** @var Formatter $formatter */
            $formatter = $this->formatter;

            foreach ($this->data as $iso_code => $settings) {
                $actual = $formatter::format($settings['sample_number'], $iso_code);
                $expected = $settings['sample_string'];

                expect($actual)->toBe($expected);
            }
        });

        it('formats a number into a currency string 2', function () {
            /** @var Formatter $formatter */
            $formatter = $this->formatter;

            $actual = $formatter::format(6999.99, 'FRA');
            $expected = '6.999,99€ EUR';

            expect($actual)->toBe($expected);
        });

        it('allows format settings to be overriden', function () {
            /** @var Formatter $formatter */
            $formatter = $this->formatter;

            $actual = $formatter::format('1234.56', 'CLP', [
                'currency_symbol' => '!@#',
                'decimal_spaces' => 4,
                'decimal_separator' => ',,',
                'thousand_separator' => '..',

            ]);
            $expected = '!@#1..234,,5600 CLP';

            expect($actual)->toBe($expected);
        });
    });
});
