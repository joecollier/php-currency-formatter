<?php
namespace Axm\Currency;

use Cake\Utility\Inflector;

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

                foreach ($defaults as $property => $expected) {
                    $getter_func = 'get' . Inflector::variable($property);
                    $actual = $currency_config->{$getter_func}();

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
});
