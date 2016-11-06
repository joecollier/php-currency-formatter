<?php
namespace Axm\Currency;

/**
 * Class Collection
 *
 * @package Axm\Currency
 */
class Collection
{
    /**
     * The array of Currency Config objects loaded
     *
     * @var array
     */
    protected $collection = [];

    /**
     * Adds a Currency Config object to the collection if one does not already exist with the same iso code
     *
     * @param Config $currency_config The Currency Config object to add
     *
     * @throws \InvalidArgumentException
     */
    public function push(Config $currency_config)
    {
        $key = $currency_config->getIsoCode();

        if ($this->hasKey($key)) {
            throw new \InvalidArgumentException('The key `' . $key . '` already exists');
        }

        $this->collection[$currency_config->getIsoCode()] = $currency_config;
    }

    /**
     * Adds a Currency Config object to the collection replacing an exisitng object with the same iso code
     *
     * @param Config $currency_config The Currency Config object to add
     */
    public function override(Config $currency_config)
    {
        $this->collection[$currency_config->getIsoCode()] = $currency_config;
    }

    /**
     * Returns true if an existing Currency Config object exists with the given iso code
     *
     * @param $iso_code The key/iso code to check
     *
     * @return bool
     */
    public function hasKey($iso_code)
    {
        return in_array($iso_code, array_keys($this->collection));
    }

    /**
     * Retrieves a Currency Config object with the given key/iso code if it exists
     *
     * @param $iso_code The key/iso code of the object to retrieve
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function get($iso_code)
    {
        if (!$this->hasKey($iso_code)) {
            throw new \InvalidArgumentException('The key `' . $iso_code . '` does not exist');
        }

        return $this->collection[$iso_code];
    }
}
