<?php
namespace Axm\Currency;

use Axm\Tests\Helpers\ReflectionHelper;

describe(Collection::class, function () {
    describe('push', function () {
        context('when a collection key exists', function () {
            it('throws an exception', function () {
                $currency_config = new Config('foo');
                $currency_collection = new Collection;
                $currency_collection->push($currency_config);

                $closure = function () use ($currency_config, $currency_collection) {
                    $currency_collection->push($currency_config);
                };

                expect($closure)->toThrow(new \InvalidArgumentException);
            });
        });

        context('when a collection key does not exist', function () {
            it('adds the config to the collection', function () {
                $iso_code = 'FOO';

                $currency_collection = new Collection;
                $collection_array1 = ReflectionHelper::getPropertyValue($currency_collection, 'collection');

                expect($collection_array1)->toHaveLength(0);

                $currency_config = new Config($iso_code);
                $currency_collection->push($currency_config);
                $collection_array2 = ReflectionHelper::getPropertyValue($currency_collection, 'collection');

                expect($collection_array2)->toHaveLength(1);
                expect($collection_array2[$iso_code])->toBe($currency_config);
            });
        });
    });

    describe('override', function () {
        context('when a collection key exists', function () {
            it('does not throw an exception', function () {
                $currency_config = new Config('foo');
                $currency_collection = new Collection;
                $currency_collection->push($currency_config);

                $closure = function () use ($currency_config, $currency_collection) {
                    $currency_collection->override($currency_config);
                };

                expect($closure)->not->toThrow();
            });
        });

        context('when a collection key does not exist', function () {
            it('adds the config to the collection', function () {
                $iso_code = 'FOO';
                $currency_collection = new Collection;
                $currency_config = new Config($iso_code);
                $currency_collection->override($currency_config);
                $collection_array = ReflectionHelper::getPropertyValue($currency_collection, 'collection');

                expect($collection_array)->toHaveLength(1);
                expect($collection_array[$iso_code])->toBe($currency_config);
            });
        });
    });

    describe('get', function () {
        context('when the key does not exists', function () {
            it('throws an exception', function () {
                $currency_collection = new Collection;

                $closure = function () use ($currency_collection) {
                    $currency_collection->get('bad_key');
                };

                expect($closure)->toThrow(new \InvalidArgumentException);
            });
        });

        context('when the collection key exists', function () {
            it('retrieves the config instance', function () {
                $iso_code = 'FOO';
                $currency_collection = new Collection;
                $currency_config = new Config($iso_code);
                $currency_collection->push($currency_config);

                expect($currency_collection->get($iso_code))->toBe($currency_config);
            });
        });
    });
});
