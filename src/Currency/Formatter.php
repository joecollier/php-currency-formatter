<?php
namespace Axm\Currency;

class Formatter
{
    /**
     * The default key/iso code to use
     */
    const DEFAULT_KEY = 'USD';

    /**
     * @var Collection
     */
    protected static $collection;

    /**
     * @var Config The Currency Config to use to build the formatted string
     */
    protected static $config;

    /**
     * Sets the Currency Collection to be used when formatting currencies
     *
     * @param Collection $collection
     */
    public static function setCollection($collection)
    {
        self::$collection = $collection;
    }

    /**
     * Returns the current Currency Collection used when formatting currencies
     *
     * @return Collection
     */
    public static function getCollection()
    {
        return self::$collection;
    }

    /**
     * Returns a currency formatted string according to the Currency Config
     *
     * @param string|number $number The string or number to format
     * @param string $format_key A key correlating to the Currency Config in the Currency Collection
     * @param array $config_overrides Optional properties to use in place of the Currency Config properties
     *
     * @return string A formatted string according to the Currency Config properties
     */
    public static function format($number, $format_key = self::DEFAULT_KEY, array $config_overrides = [])
    {
        $config = self::getFormatConfig($format_key, $config_overrides);

        $symbol = self::handleSymbol($config);
        $number = self::handleNumber($number, $config);
        $label = self::handleLabel($config);

        return self::handleFormat($symbol, $number, $label);
    }

    /**
     * @param string $format_key A key correlating to the Currency Config in the Currency Collection
     * @param array $config_overrides Properties to use in place of the Currency Config properties
     *
     * @return Config The Currency Config to use to build the formatted string
     */
    protected static function getFormatConfig($format_key, array $config_overrides)
    {
        $key = self::$collection->hasKey(strtoupper($format_key))
            ? strtoupper($format_key)
            : self::$default_format_key;
        return self::$collection->get($key, $config_overrides);
    }

    /**
     * Returns the Currency Symbol according to the Currency Config properties
     *
     * @param Config $config The Currency Config to use to build the formatted string
     *
     * @return string The Currency Symbol according to the Currency Config
     */
    protected static function handleSymbol(Config $config)
    {
        return $config->getCurrencySymbol();
    }

    /**
     * Formats a string or number according to the Currency Config
     *
     * @param string|number $number The string or number to format
     * @param Config $config The Currency Config to use to build the formatted string
     *
     * @return number The formatted number according to the Currency Config properties
     */
    protected static function handleNumber($number, Config $config)
    {
        return number_format(
            $number,
            $config->getDecimalSpaces(),
            $config->getDecimalSeparator(),
            $config->getThousandSeparator()
        );
    }

    /**
     * Returns the Currency Label according to the Currency Config properties
     *
     * @param Config $config The Currency Config to use to build the formatted string
     *
     * @return string The country ISO code according to the Currency Config
     */
    protected static function handleLabel(Config $config)
    {
        $label = $config->getLabel();

        return (trim($label) === '')
            ? ''
            : ' ' . $label;
    }

    /**
     * Returns the currency formatted string
     *
     * @param string $symbol
     * @param number $number
     * @param string $label
     *
     * @return string A formatted string
     */
    protected static function handleFormat($symbol, $number, $label)
    {
        return sprintf('%s%s%s', $symbol, $number, $label);
    }
}
