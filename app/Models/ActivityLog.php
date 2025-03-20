<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{

    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'action',
        'user_id',
        'card_id',
        'board_id',
    ];

    /**
     * Get the user that performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the card related to the activity.
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    /**
     * Get the board related to the activity.
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}
