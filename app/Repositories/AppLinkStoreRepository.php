<?php

namespace App\Repositories;

use App\Models\AppLinkStore;
use App\Repositories\BaseRepository;

/**
 * Class AppLinkStoreRepository
 * @package App\Repositories
 * @version January 25, 2024, 5:27 pm +07
*/

class AppLinkStoreRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'app_id',
        'app_name',
        'link_store'
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
        return AppLinkStore::class;
    }
}
