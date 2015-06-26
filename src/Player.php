<?php
namespace Mooph;

/**
 * Maarten van Leeuwen <maarten@significantbits.nl>
 * 26-6-15 21:03
 */ 

class Player
{
    /** @var string uuid */

    private $id;

    /** @var resource */
    private $brain;

    public function __construct($id, Brain $brain)
    {
        $this->id = $id;
        $this->brain = $brain;
    }
}




