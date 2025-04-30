<?php
namespace BatAPI\Utils;

function dd(...$args)
{
    var_dump(...$args);
    die;
}