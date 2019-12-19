<?php

namespace Gamez\Illuminate\Support\Tests;

use Illuminate\Contracts\Support\Arrayable;

class ArrayableItem implements Arrayable
{
    public $id;
    private $name;

    public function __construct($id = null, $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function toArray()
    {
        return [];
    }

    public function getName()
    {
        return $this->name;
    }
}
