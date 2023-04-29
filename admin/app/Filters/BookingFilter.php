<?php

// BookingFilter.php

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class BookingFilter extends AbstractFilter
{
    protected $filters = [
        'type' => TypeFilter::class
    ];
    
    public function apply($query)
    {
        foreach ($this->receivedFilters() as $name => $value) {
            $filterInstance = new $this->filters[$name];
            $query = $filterInstance($query, $value);
        }

        return $query;
    }
    
    public function receivedFilters()
    {
        return request()->only(array_keys($this->filters));
    }
}