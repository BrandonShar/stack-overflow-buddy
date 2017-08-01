<?php

namespace brandonshar;

use PhpParser\PrettyPrinter;

class ParsedCode
{
    function __construct($answer, $parsedCode)
    {
        $this->answer = $answer;
        $this->parsedCode = collect($parsedCode);
        $this->prettyPrinter = new PrettyPrinter\Standard();
    }

    static function new($answer, $parsedCode)
    {
        $parsedCode = collect($parsedCode);
        $isFunction = function ($node) {
            return $node instanceof \PhpParser\Node\Stmt\Function_;
        };

        return $parsedCode->contains($isFunction) 
            ? new static($answer, $parsedCode->filter($isFunction))
            : static::null();
    }

    static function null()
    {
        return new NullParsedCode;
    }

    function attemptExecution($args)
    {
        return $this->checkArgs($args)->attempt($this->method, $args);
    }

    function checkArgs($args)
    {
        $method = $this->parsedCode->first(function ($code) use ($args) {
            return count($args) === count($code->params);
        });

        return ($this->method = $method ? $method->name : false)
            ? $this : static::null();
    }

    function attempt($method, $args)
    {
        return $this->answer->tap(function ($a) use ($args, $method) {
            $a->args = $args;
            $a->method = $method;
            $a->code = $this->prettyPrinter->prettyPrint($this->parsedCode->all());
        });
    }
}

class NullParsedCode
{
    function attemptExecution($_) {}
    function attempt($_, $__) {}
}
