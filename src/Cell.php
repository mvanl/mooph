<?php
/**
 * Maarten van Leeuwen <maarten@significantbits.nl>
 * 26-6-15 23:47
 */ 

namespace Mooph;


class Cell 
{
    private $owner;

    public function __construct($owner = null)
    {
        $this->owner = $owner;
    }

    public function owner()
    {
        return $this->owner;
    }
}