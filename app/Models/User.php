<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Team;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ADMIN_TYPE = 'admin';
    const USER_TYPE = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'security_key',
        'address',
        'phone_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->type === self::ADMIN_TYPE;
    }

    public function isUser()
    {
        return $this->type === self::USER_TYPE;
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'user_team', 'user_id', 'team_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission', 'user_id', 'permission_id');
    }

    /**
     * Get the workspaces owned by the user.
     */
    public function ownedWorkspaces()
    {
        return $this->hasMany(Workspace::class, 'owner_id');
    }

    /**
     * Get the workspaces that the user is a member of.
     */
    public function workspaces()
    {
        return $this->belongsToMany(Workspace::class, 'workspace_users')
            ->withPivot('role')
            ->withTimestamp('created_at');
    }

    /**
     * Get the boards owned by the user.
     */
    public function ownedBoards()
    {
        return $this->hasMany(Board::class, 'owner_id');
    }

    /**
     * Get the boards that the user is a member of.
     */
    public function boards()
    {
        return $this->belongsToMany(Board::class, 'board_users')
            ->withPivot('role')
            ->withTimestamp('created_at');
    }

    /**
     * Get the comments created by the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the activity logs created by the user.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Get the cards assigned to the user.
     */
    public function assignedCards()
    {
        return $this->belongsToMany(Card::class, 'card_assignees');
    }
}
