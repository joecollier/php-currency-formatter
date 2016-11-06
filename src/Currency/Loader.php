<?php
namespace Axm\Currency;

/**
 * Class Loader
 *
 * @package Axm\Currency
 */
class Loader
{
    /**
     * Returns a Currency Formatter using an array of Currency Config properties
     *
     * @param array $settings an associative array config settings using the country iso code and keys
     *
     * @return Formatter
     */
    public static function fromArray(array $settings)
    {
        $collection = new Collection;

        foreach ($settings as $iso_code => $config_settings) {
            $config = new Config($iso_code, $config_settings);
            $collection->push($config);
        }

        $formatter = new Formatter;
        $formatter::setCollection($collection);

        return $formatter;
    }
}
