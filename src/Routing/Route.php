<?php

namespace BatAPI\Routing;

class Route
{
    //  =========================== PARAMS ===========================

    //  =========================== PUBLIC METHODS ===========================

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

    /**
     * Check whether the passed uri matches this route's uri
     *
     * @param string $uri
     * @return boolean
     */
    public function uriMatches(string $uri): bool
    {
        return strtolower($this->uri()) === strtolower($uri);
    }

    public function call()
    {
        if ($this->callableType === 'closure') {
            return call_user_func($this->callable);
        }

        // TODO: if the callable type is not a closure.
    }

    //  =========================== INTERNAL METHODS ===========================
}