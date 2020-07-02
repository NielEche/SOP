<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'user_id', 'from_latitude', 'from_longitude', 'from_location',
        'to_latitude', 'to_longitude', 'to_location',
        'start_date', 'end_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Get the user that owns the activity.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

    /**
     * Get the people attached to the  activity.
     */
    public function people()
    {
        return $this->hasMany('App\ActivityPeople');
    }
}
