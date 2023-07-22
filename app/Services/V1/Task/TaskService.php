<?php

namespace App\Services\V1\Task;

use App\Models\Task;
use App\Models\User;
use App\Services\V1\BaseService;
use App\Events\AssignNewTaskEvent;


class TaskService  extends BaseService
{
    public function __construct(Task $model,User $user)
    {
        parent::__construct($model);
        $this->user=$user;
    }


    public function store($data)
    {
        try {
            $data['created_by']=auth()->user()->id;
            $this->storeOrUpdate($data);

            $assignUser=$this->user->find($data['assign_to']);
            event(new AssignNewTaskEvent($assignUser));
            return true;
        } catch (\Exception $e) {
            $this->logErrorResponse($e);
        }

    }

    public function getAllUsers()
    {
        return $this->user->all();
    }

}
