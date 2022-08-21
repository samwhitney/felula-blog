<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'user_id',
        'enabled'
    ];

	// Eager load the author that owns the post
	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	// Set the route key to be used for this model
 	public function getRouteKeyName() {
		return 'slug';
 	}

}
