<?php
// TypeFilter.php

namespace App\Filters;

class TypeFilter
{
    public function filter()
    {
        return $builder->where('type', $value);
    }

}