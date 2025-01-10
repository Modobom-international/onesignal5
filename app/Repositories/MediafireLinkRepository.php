<?php

namespace App\Repositories;

use App\Models\MediafireLink;
use App\Repositories\BaseRepository;

/**
 * Class MediafireLinkRepository
 * @package App\Repositories
 * @version August 22, 2022, 3:08 pm +07
*/

class MediafireLinkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'link',
        'name',
        'status'
    ];

    public function create($input)
    {
        //get type of link (mediafire or autobuild)
        if (strpos($input['link'], 'mediafire') !== false) {
            $input['type'] = 'mediafire';
        } else {
            $input['type'] = 'autobuild';
        }

        $model = $this->model->newInstance($input);

        $model->save();

        return $model;
    }


    public function update($input, $id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        //get type of link (mediafire or autobuild)
        if (strpos($input['link'], 'mediafire') !== false) {
            $input['type'] = 'mediafire';
        } else {
            $input['type'] = 'autobuild';
        }

        $model->fill($input);

        $model->save();

        return $model;
    }

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
        return MediafireLink::class;
    }
}
