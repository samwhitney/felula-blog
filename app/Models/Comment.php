<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post_id',
        'name',
        'email',
        'comment'
    ];

	// Eager load the post that owns the comment
	public function post()
	{
		return $this->belongsTo(Post::class, 'post_id');
	}
}
