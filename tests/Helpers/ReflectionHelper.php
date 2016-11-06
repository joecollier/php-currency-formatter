<?php
namespace Axm\Tests\Helpers;

use Cake\Utility\Inflector;

/**
 * Class ReflectionHelper
 *
 * @package Axm\Tests\Helpers
 */
class ReflectionHelper
{
    /**
     * Retrieves the value of a protected or private property of a given object
     *
     * @param object $object The object holding the protected or private property
     * @param string $property The property name to retrieve
     *
     * @return mixed
     */
    public static function getDirectPropertyValue($object, $property)
    {
        $r = new \ReflectionObject($object);
        $prop = $r->getProperty($property);
        $prop->setAccessible(true);
        return $prop->getValue($object);
    }

    /**
     * Retrieves the property value of a given object using a getter method
     *
     * @param object $object The object holding the protected or private property
     * @param string $property The property name to retrieve
     *
     * @return mixed
     */
    public static function getGetterPropertyValue($object, $property)
    {
        $getter_func = static::buildGetterFromProperty($property);
        return $object->{$getter_func}();
    }

    /**
     * Returns a getter method name based on the property name
     *
     * @param string $property_name
     * @return string
     */
    public static function buildGetterFromProperty($property_name)
    {
        return 'get' . Inflector::variable($property_name);
    }
}
