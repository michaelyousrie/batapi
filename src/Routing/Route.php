<?php

namespace BatAPI\Routing;

use Closure;
use BatAPI\Controller;

use function BatAPI\Utils\dd;

class Route
{
    //  =========================== PARAMS ===========================

    //  =========================== PUBLIC METHODS ===========================

    public function __construct(private string $uri, private mixed $callable)
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
        if ($this->callable instanceof Closure) {
            return call_user_func($this->callable);
        }

        if (is_array($this->callable)) {
            return Controller::determine($this->callable);
        }

        dd('Unknown Callable type for this route.');
    }

    //  =========================== INTERNAL METHODS ===========================
}