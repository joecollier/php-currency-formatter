<?php
namespace Axm\Tests\Helpers;

class ReflectionHelper
{
    public static function getPropertyValue($object, $property)
    {
        $r = new \ReflectionObject($object);
        $prop = $r->getProperty($property);
        $prop->setAccessible(true);
        return $prop->getValue($object);
    }
}
