<?php

namespace App\Traits;

trait Singleton
{
    protected static $instance = null;

    /** call this method to get instance */
    public static function instance()
    {
        if (static::$instance === null) {
            static::$instance = app()->make(self::class);
        }
        return static::$instance;
    }

    /** protected to prevent cloning */
    protected function __clone()
    {
    }

}
