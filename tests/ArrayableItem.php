<?php

namespace Gamez\Illuminate\Support\Tests;

use Illuminate\Contracts\Support\Arrayable;

class ArrayableItem implements Arrayable
{
    public function toArray()
    {
        return [];
    }
}
