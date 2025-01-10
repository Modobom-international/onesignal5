<?php

namespace App\Repositories;

use App\Models\ApkAmazonNoBuild;
use App\Repositories\BaseRepository;

/**
 * Class ApkAmazonNoBuildRepository
 * @package App\Repositories
 * @version January 26, 2024, 3:03 pm +07
*/

class ApkAmazonNoBuildRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'filename',
        'title',
        'bucket',
        'link'
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
        return ApkAmazonNoBuild::class;
    }
}
