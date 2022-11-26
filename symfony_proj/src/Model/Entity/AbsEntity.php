<?php

namespace App\Model\Entity;

use JsonSerializable;

abstract class AbsEntity implements JsonSerializable
{
    public function jsonSerialize() {
        return get_object_vars($this);
    }
}