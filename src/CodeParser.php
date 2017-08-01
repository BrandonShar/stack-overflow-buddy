<?php

namespace brandonshar;

use PhpParser\Error;
use PhpParser\ParserFactory;

class CodeParser
{
    private static $instance;

    private function __construct()
    {
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);
    }

    static function instance() {
        return static::$instance ?? (static::$instance = new static());
    }

    function parse($answer)
    {
        try {
            return ParsedCode::new($answer, $this->parser->parse("<?php {$answer}"));
        } catch (Error $e) {
            return ParsedCode::null();
        }
    }
}
