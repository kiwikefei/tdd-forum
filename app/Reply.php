<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
