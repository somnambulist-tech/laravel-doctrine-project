<?php

namespace App\Support;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class AppEnumeration
 *
 * @package    App\Support
 * @subpackage App\Support\AppEnumeration
 */
abstract class AppEnumeration extends AbstractEnumeration
{

    /**
     * @var array
     */
    private static $cache = [];

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value();
    }

    /**
     * @return array
     */
    public static function values()
    {
        $class = get_called_class();

        if (!isset(static::$cache[$class])) {
            static::$cache[$class] = [];

            /** @var static $member */
            foreach (static::members() as $member) {
                static::$cache[$class][$member->key()] = $member->value();
            }
        }

        return static::$cache[$class];
    }

    /**
     * Array to be used by form choice fields.
     *
     * @return array
     */
    public static function choices()
    {
        return array_combine(static::values(), static::values());
    }
}
