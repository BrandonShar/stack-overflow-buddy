<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use brandonshar\StackOverflowBuddy;
use brandonshar\HaveToWriteYourOwnCodeException;
use brandonshar\UnnecessarilyGratefulException;

class StackOverflowBuddyTest extends TestCase
{
    function setUp()
    {
        parent::setUp();
        StackOverflowBuddy::$api = 'stackoverflow.dev/';
    }

    function test_it_finds_and_executes_good_code()
    {
        $this->assertEquals([1, 2, 3, 4, 5], StackOverflowBuddy::mergeSort([3, 5, 1, 2, 4]));
    }

    function test_it_caches_and_returns_good_code()
    {
        $this->assertEquals([1, 2, 3, 4, 5], StackOverflowBuddy::mergeSort([3, 5, 1, 2, 4]));
        $this->assertEquals([1, 2, 3, 4, 5], StackOverflowBuddy::mergeSort([3, 5, 1, 2, 4]));
    }

    function test_it_throws_away_non_function_code()
    {
        StackOverflowBuddy::$api = 'stackoverflow.dev/extracode/';
        $this->assertEquals(['atyp'], StackOverflowBuddy::getStringBetweenTwoStrings('pl', 'us', 'platypus'));
    }

    function test_it_provides_attribution()
    {
        StackOverflowBuddy::mergeSort([3, 5, 1, 2, 4]);
        $this->assertEquals([
            'author'        => 'Kartik',
            'authorLink'    => 'https://stackoverflow.com/users/325499/kartik',
            'questionLink'  => 'https://stackoverflow.com/a/9401135',
        ], StackOverflowBuddy::giveThanksFor('mergeSort'));

    }

    function test_it_doesnt_let_you_thank_no_one()
    {
        $this->expectException(UnnecessarilyGratefulException::class);
        StackOverflowBuddy::giveThanksFor('something');
    }

    function test_it_throws_exception_with_no_results() 
    {
        StackOverflowBuddy::$api = 'stackoverflow.dev/empty/';
        $this->expectException(HaveToWriteYourOwnCodeException::class);  
        StackOverflowBuddy::anything('x');  
    }

    function test_it_throws_exception_with_bad_results()
    {
        StackOverflowBuddy::$api = 'stackoverflow.dev/bad/';
        $this->expectException(HaveToWriteYourOwnCodeException::class);  
        StackOverflowBuddy::anything('x'); 
    }

    function test_it_handles_being_rate_limited_by_stack_overflow()
    {
        StackOverflowBuddy::$api = 'stackoverflow.dev/rate-limit/';
        $this->expectException(HaveToWriteYourOwnCodeException::class);
        StackOverflowBuddy::anything();
    }
}