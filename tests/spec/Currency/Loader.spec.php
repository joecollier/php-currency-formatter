<?php
namespace Axm\Currency;

use Axm\Tests\Helpers\ReflectionHelper;

describe(Loader::class, function () {
    describe('fromArray', function () {
        beforeEach(function () {
            $json = file_get_contents(FACADES_DIR . 'currency_configs.json');
            $this->data = json_decode($json, true);
            $this->formatter = Loader::fromArray($this->data);
            $this->collection = ReflectionHelper::getDirectPropertyValue($this->formatter, 'collection');
        });
        it('Creates a ' . Collection::class . ' for the ' . Formatter::class, function () {
            expect($this->collection)->toBeAnInstanceOf(Collection::class);
        });

        it('Creates a ' . Collection::class . ' using the array', function () {
            expect($this->collection)->toHaveLength(count($this->data));
        });

        it('Returns a Currency Formatter', function () {
            expect($this->formatter)->toBeAnInstanceOf(Formatter::class);
        });
    });
});
