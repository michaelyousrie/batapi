<?php
namespace BatAPI\Utils;

function dd(...$args): void
{
    foreach($args as $arg) {
        if (is_array($arg)) {
            echo "<pre>". JSON::encode($arg) . "</pre>";
            continue;
        }
        var_dump($arg);
    }

    die;
}