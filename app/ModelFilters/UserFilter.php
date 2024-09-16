<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function status($status)
    {
        return $this->where(function ($query) use ($status) {
            if (in_array('disabled', $status)) {
                $this->withTrashed();
                $query->whereNotNull('deleted_at');
            }
            if (in_array('active', $status)) $query->orWhereNull('deleted_at');
        });
    }
    
    public function roles($roles)
    {
        return $this->related('roles', function ($query) use ($roles) {
            return $query->whereIn('name', $roles);
        });
    }
}
