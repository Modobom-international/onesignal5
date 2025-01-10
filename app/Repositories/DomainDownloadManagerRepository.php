<?php

namespace App\Repositories;

use App\Models\DomainDownloadManager;
use App\Repositories\BaseRepository;

/**
 * Class DomainDownloadManagerRepository
 * @package App\Repositories
 * @version January 19, 2024, 7:17 pm +07
*/

class DomainDownloadManagerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'domain',
        'created_at',
        'updated_at',
        'picked_at'
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
        return DomainDownloadManager::class;
    }
}
