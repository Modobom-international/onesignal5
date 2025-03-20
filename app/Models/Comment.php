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
        'description',
        'user_id',
        'card_id',
        'parent_comment_id',
    ];

    /**
     * Get the user that created the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the card that the comment belongs to.
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    /**
     * Get the parent comment.
     */
    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    /**
     * Get the replies to the comment.
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }
}
