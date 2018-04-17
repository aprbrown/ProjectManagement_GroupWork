<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class taskComment extends Model
{
    protected $guarded =[];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
