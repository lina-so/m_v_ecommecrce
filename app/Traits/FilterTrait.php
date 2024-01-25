<?php

namespace App\Traits;


trait FilterTrait
{
    public function scopeFilterByFields($query, $fields, $tableName)
    {
        foreach ($fields as $field => $value) {
            if ($value !== null) {
                if ($field == 'name') {
                    $query->where($tableName . '.' . $field, 'LIKE', '%' . $value . '%');
                } elseif ($field == 'status') {
                    $query->where($tableName . '.' . $field, $value);
                }
            }
        }
        return $query;
    }
}
