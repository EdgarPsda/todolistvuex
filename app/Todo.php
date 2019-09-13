<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['description', 'due_date', 'user_id'];
    protected $hidden = ['email_verified_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
     }
}
