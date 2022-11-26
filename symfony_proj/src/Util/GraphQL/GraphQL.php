<?php


namespace App\Util\GraphQL;


class GraphQL
{
    const BEGIN = '{';
    const END = '}';
    const PART = ' ';
    const NEWLINE = ' ';

    private $fields = [];

    private Source $source;

    private Condition $condition;

    private int $limit;

    public function __construct(array $fields, Source $source, Condition $condition, int $limit = 1) {
        $this->fields = $fields;
        $this->source = $source;
        $this->condition = $condition;
        $this->limit = $limit;
    }

    public function __toString() : string {
        $str = '';
        foreach ($this->fields as $field) {
            $str .= $field . self::NEWLINE;
        }
        return $this->source->getName() . self::PART . $this->condition . self::PART
            . self::BEGIN
                . $str
            . self::END;
    }

    public function query() : Source {

        return new Source();
    }
}