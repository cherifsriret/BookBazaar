<?php

/**
 *
 */
class App
{
  private static $app = [];

  public static function get($c)
  {
    return static::$app[$c];
  }

  public static function set($k, $v)
  { 
     static::$app[$k] = $v;
  }

  public static function load_config($fileName)
  {
     static::$app['config'] = require($fileName);
  }
}
