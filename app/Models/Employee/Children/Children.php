<?php

namespace App\Models\Employee\Children;

use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
	protected $fillable = [
        'dependent_id',		
        'name',
        'dependent',
        'date',
        'age',
        'gender',
        'relationship',
    ];

    public function children() {
        return $this->belongsTo(Children::class);
    }
}
