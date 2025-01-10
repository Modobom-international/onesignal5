<?php

namespace App\Repositories;

use App\Models\LoadWebCount;
use App\Repositories\BaseRepository;

/**
 * Class LoadWebCountRepository
 * @package App\Repositories
 * @version January 29, 2024, 5:28 pm +07
*/

class LoadWebCountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'game',
        'max_post',
        'link_post'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LoadWebCount::class;
    }
}
