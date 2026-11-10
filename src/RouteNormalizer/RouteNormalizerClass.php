<?php

/**
 * Summary of RouteNormalizer
 * 
 * It borns as a subyacent need to always get 
 * the Service and Function of an endpoint to
 * help APIRouter implementation. 
 * An example of its working is: 
 * - Original Route: /root/public/api/Captcha/Generate
 * - Encapsulated One: /Captcha/Generate
 * 
 * @package RouteNormalizer
 */

class RouteNormalizer
{

    private array $path;


    public function __construct(string $route)
    {
        $pos = strpos($route, "?");

        if($pos !== false)
             $route = substr($route, 0, $pos);
             
        $this->path = array_slice(explode('/', $route), -2, 2);
    }

    /**
     * Summary of get
     * 
     * Get the position of each path.
     * Tipically being 0 -> Service & n -> Function.
     * If the position does not exist, return null.
     * 
     * @param int $pos service or function to get
     * @return string|null service or function
     */
    public function get(int $pos) : string
    {
        if($pos >= count($this->path) || $pos < 0) return null;

        return ucfirst($this->path[$pos]);
    }

    /**
     * Summary of __tostring
     * 
     * It forms the complete endpoint route.
     * F.I /Captcha/Generate
     * @return string Valid EndPoint route
     */
    public function __tostring() : string
    {
        $result = "";

        for ($i=0; $i < count($this->path); $i++)
        { 
            $result .= ($i + 1 < count($this->path)) ? $this->get($i) . "/" : $this->get($i);
        }

        return $result;
    }

}