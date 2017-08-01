<?php

namespace brandonshar;

use Zttp\Zttp;
use Zttp\ZttpResponse;

class CodeFinder
{
    function __construct()
    {
        $this->api = StackOverflowBuddy::$api;

        ZttpResponse::macro('collect', function () {
            if (!array_key_exists('items', $this->json())) {
                throw new HaveToWriteYourOwnCodeException('Looks like the stackexchange api is tired of helping you');
            }
            return collect($this->json()['items']);
        });
    }

    static function new()
    {
        return new self;
    }

    function findCode($method)
    {
        return $this->getAnswers( 
            $this->getQuestionIds(strtolower(Str::splitCamelCase($method)))
        )->map(function ($item) {
            return $this->extractCode($item['body'])->map(function ($code) use ($item) {
                return Answer::new($item, $code);
            });
        })->flatten();
    }

    function getQuestionIds($search)
    {
        return Zttp::get($this->api.'search', [
            'order'     => 'desc',
            'sort'      => 'votes',
            'tagged'    => 'php',
            'site'      => 'stackoverflow',
            'intitle'   => urlencode($search),
        ])->collect()->pluck('question_id')->implode(';');
    }

    function getAnswers($questionIds)
    {
        return $questionIds ? Zttp::get("{$this->api}questions/{$questionIds}/answers", [
            'order'     => 'desc',
            'sort'      => 'votes',
            'site'      => 'stackoverflow',
            'filter'    => '!0WyEumH)CFikxBBVsfnDZQar5',
        ])->collect() : collect();
    }

    function extractCode($potentialCode)
    {
        return collect(
            preg_match_all("/<code>(.*?)<\/code>/", str_replace(["\r", "\n"], '', $potentialCode), $results)
                ? collect($results[1])->map(function ($code) { return html_entity_decode($code); })
                : false
        )->filter();
    }
}
