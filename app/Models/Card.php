<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'list_id',
        'position',
        'due_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'datetime',
    ];

    /**
     * Get the list that the card belongs to.
     */
    public function list()
    {
        return $this->belongsTo(ListModel::class, 'list_id');
    }

    /**
     * Get the comments on the card.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the activity logs related to the card.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Get the labels attached to the card.
     */
    public function labels()
    {
        return $this->belongsToMany(Label::class, 'card_labels');
    }

    /**
     * Get the users assigned to the card.
     */
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'card_assignees');
    }

    /**
     * Get the checklists for the card.
     */
    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

    /**
     * Get the attachments for the card.
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
