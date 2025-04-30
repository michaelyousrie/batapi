<?php
namespace BatAPI\Utils;

function dd(...$args): void
{
    var_dump(...$args);
    die;
}