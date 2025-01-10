<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class LoadWebCount
 * @package App\Models
 * @version January 29, 2024, 5:28 pm +07
 *
 * @property string $game
 * @property integer $max_post
 * @property string $link_post
 */
class LoadWebCount extends Model
{

    public $table = 'load_web_counts';




    public $fillable = [
        'game',
        'max_post',
        'link_post',
        'link_return'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'game' => 'string',
        'max_post' => 'integer',
        'link_post' => 'string',
        'link_post' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'game' => 'required|max:255',
        'max_post' => 'required|integer'
    ];
}
