<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'card_id',
        'title',
    ];

    /**
     * Get the card that the checklist belongs to.
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    /**
     * Get the items in the checklist.
     */
    public function items()
    {
        return $this->hasMany(ChecklistItem::class);
    }
}
