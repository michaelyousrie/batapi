<?php

namespace BatAPI\Interfaces;

abstract class DataSource
{
    public function __construct(protected mixed $source)
    {
    }
}