<?php

namespace App\Repositories;

use App\Provider;

class ProviderRepository extends DbRepository
{
    /**
     * Construct
     * @param User $model
     */
    public function __construct(Provider $model)
    {
        $this->model = $model;
        $this->limit = 10;
    }

    /**
     * save a user
     * @param $data
     */
    public function store($data)
    {
        $data = $this->prepareData($data);

        $user = $this->model->create($data);

        return $user;
    }

    /**
     * Update a user
     * @param $id
     * @param $data
     * @return \Illuminate\Support\Collection|static
     */
    public function update($user, $data)
    {
        //$user = $this->model->findOrFail($id);
        $data = $this->prepareData($data);

        $user->fill($data);

        $user->save();

        return $user;
    }

    private function prepareData($data)
    {
        return $data;
    }
}
