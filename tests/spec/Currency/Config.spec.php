<?php
namespace Axm\Currency;

use Axm\Tests\Helpers\ReflectionHelper;

describe(Config::class, function () {
    describe('__constructor', function () {
        context('when a property value is not passed', function () {
            it('uses the default value', function () {
                $currency_config = new Config('foo');

                $defaults = [
                    'currency_symbol' => '$',
                    'decimal_spaces' => 2,
                    'decimal_separator' => '.',
                    'thousand_separator' => ','
                ];

                foreach ($defaults as $property_name => $expected) {
                    $actual = ReflectionHelper::getGetterPropertyValue($currency_config, $property_name);

                    expect($actual)->toBe($expected);
                }
            });
        });
    });

    describe('getIsoCode', function () {
        it('returns the iso provided', function () {
            expect((new Config('foo'))->getIsoCode())->toBe('FOO');
        });
    });

    describe('buildFromOverride', function () {
        it('creates a Currency Config from an existing one with additional properties', function () {
            $base_currency_config = new Config('foo');
            $overrides = [
                'currency_symbol' => '~',
                'decimal_spaces' => 1,
                'decimal_separator' => '!',
                'thousand_separator' => '@'
            ];
            $currency_config = Config::buildFromOverride($base_currency_config, $overrides);

            foreach ($overrides as $property_name => $expected) {
                $actual = ReflectionHelper::getGetterPropertyValue($currency_config, $property_name);

                expect($actual)->toBe($expected);
            }
        });
    });
});
