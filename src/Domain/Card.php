<?php

namespace Src\Domain;

class Card
{
    public int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}