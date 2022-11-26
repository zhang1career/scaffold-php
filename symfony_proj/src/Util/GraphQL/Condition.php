<?php


namespace App\Util\GraphQL;


class Condition
{
    const BEGIN = '(';
    const END = ')';
    const PART = ' ';

    private $conditions = [];

    public function __construct($conditions) {
        $this->conditions = $conditions;
    }

    public function __toString() : string {
        $str = '';
        foreach ($this->conditions as $k => $v) {
            $str .= $k . '=' . $v . self::PART;
        }

        return self::BEGIN
                . $str
            . self::END;
    }
}