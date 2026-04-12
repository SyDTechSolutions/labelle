<?php namespace App\Repositories;


use App\Role;
use App\User;
use Illuminate\Support\Arr;

class UserRepository extends DbRepository{


    /**
     * Construct
     * @param User $model
     */
    function __construct(User $model)
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

        $role = (isset($data['role'])) ? $data['role'] : Role::whereName('vendedor')->first();
        
        $user->assignRole($role);
    
       
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

       if(isset($data['role']))
            $user->assignRole($data['role']);


        return $user;
    }


    private function prepareData($data)
    {
        
        if(empty($data['password']))
           return $data = Arr::except($data, array('password'));

        $data['password'] = bcrypt($data['password']);


        return $data;
    }


}