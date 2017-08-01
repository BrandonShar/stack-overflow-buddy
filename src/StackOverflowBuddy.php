<?php

namespace brandonshar;

use Illuminate\Support\Collection;

class StackOverflowBuddy
{
    static $api = 'https://api.stackexchange.com/';
    static $answers = [];

    static function __callStatic($method, $args)
    {
        static::setup();

        return static::cache($method, function () use ($method, $args) {
            return CodeFinder::new()
                ->findCode($method)
                ->firstMap(function ($answer) use ($args) {
                    return CodeParser::instance()
                        ->parse($answer)
                        ->attemptExecution($args);
                }, Answer::null());
        })($args);
    }

    static function cache($method, $cacheCallback)
    {
        return static::$answers[$method] ?? (static::$answers[$method] = $cacheCallback());
    }

    static function giveThanksFor($method) {
        return static::get($method)->attribution();
    }

    static function get($method) {
        return static::$answers[$method] ?? Answer::null();
    }

    static function setup()
    {
        // this name kind of sucks. Suggestions would be great!
        Collection::macro('firstMap', function ($callback, $default = null) {
            foreach ($this as $that) {
                $result = $callback($that);
                if ($result) {
                    return $result;
                }
            }
            return $default;
        });

        Collection::macro('dd', function () {
            var_dump($this->items);
            return $this;
        });
    }
}
