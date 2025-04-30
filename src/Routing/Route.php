<?php

namespace BatAPI\Routing;

class Route
{
    public function __construct(private string $uri, private mixed $callable, private string $callableType)
    {
        //
    }

    /**
     * Get or Set the URI of the current route.
     *
     * @param string|null $newUri
     * @return Route | string
     */
    public function uri(?string $newUri = null): Route | string
    {
        if (is_null($newUri)) {
            return $this->uri;
        }

        $this->uri = $newUri;

        return $this;
    }
}