<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'board_id',
        'position',
    ];

    /**
     * Get the board that the list belongs to.
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Get the cards in the list.
     */
    public function cards()
    {
        return $this->hasMany(Card::class, 'list_id');
    }
}
