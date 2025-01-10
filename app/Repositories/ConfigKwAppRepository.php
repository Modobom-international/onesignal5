<?php

namespace App\Repositories;

use App\Models\ConfigKwApp;
use App\Repositories\BaseRepository;

/**
 * Class ConfigKwAppRepository
 * @package App\Repositories
 * @version September 13, 2022, 2:14 pm +07
*/

class ConfigKwAppRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'country',
        'name'
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
        return ConfigKwApp::class;
    }
}
