<?php

namespace App\Meta\Vo;

class Result implements \JsonSerializable
{
    public const RESULT_CODE_OK     = 0;
    public const RESULT_CODE_ERR    = 1;

    public static $msgs = [
        0   => '',
        1   => 'Something wrong!',
    ];

    public static $tips = [
        0   => 'ok',
    ];

    static public function ok($dataObj) {
        return new static(static::RESULT_CODE_OK,
                          static::$msgs[static::RESULT_CODE_OK],
                          static::$tips[static::RESULT_CODE_OK],
                          $dataObj);
    }

    static public function error($code, $tip, $dataObj) {
        return new static($code,
                          static::$msgs[$code],
                          $tip,
                          $dataObj);
    }


    private int $code;
    private string $msg;
    private string $tip;
    private $data;

    public function __construct($code, $msg, $tip, $data) {
        $this->code = $code;
        $this->msg = $msg;
        $this->tip = $tip;
        $this->data = $data;
    }

    public function __toString() : string {
        $str = json_encode($this);
        return $str ? $str : '';
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}