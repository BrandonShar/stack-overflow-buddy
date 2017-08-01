<?php

namespace brandonshar;

class Answer
{
    function __construct($answer, $code)
    {
        $this->answer = $answer;
        $this->code = $code;
    }

    function __get($arg)
    {
        return $this->answer[$arg] ?? null;
    }

    function __toString()
    {
        return $this->code;
    }

    function __invoke($args)
    {
        $this->eval();

        $method = $this->method;
        return $method(...$args);
    }

    static function new(...$args)
    {
        return new self(...$args);
    }

    static function null()
    {
        return new NullAnswer;
    }

    function tap($callback) {
        $callback($this);
        return $this;
    }

    function eval()
    {
        $this->evaled = $this->evaled ?? (eval($this->code) || true);
    }

    function attribution()
    {
        return [
            'author'        => $this->owner['display_name'],
            'authorLink'    => $this->owner['link'],
            'questionLink'  => $this->share_link
        ];
    }
}

class NullAnswer
{
    function __invoke($_)
    {
        throw new HaveToWriteYourOwnCodeException('Oh no, now we may have to actually think about this!');
    }

    function attribution() 
    {
        throw new UnnecessarilyGratefulException('No one to thank. Are you sure you\'ve been helped?');
    }
}