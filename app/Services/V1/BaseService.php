<?php

namespace App\Services\V1;

use Illuminate\Database\Eloquent\Model;
use Itclanbd\GlobalServiceDependencies\GlobalConstant;

class BaseService
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getByUserId($id, $with = [])
    {
        try {
            return $this->model::with($with)->where('user_id', $id)->first();

        } catch (\Exception $e) {
            $this->logErrorResponse($e);
        }
    }

    public function get($id = null, $with = [])
    {
        try {
            $query = $this->model::query()->with($with);

            //check if this model using softDelete before apply softDelete functions
            // if ($this->model->hasSoftDelete()  && (request('trashed') == 'true' || request('trashed') == '1')) {
            //     $query->withTrashed();
            // }
            if ($id) {
                return $query->findOrFail($id);
            } else {
                return $query->get();
            }
        } catch (\Exception $e) {
            $this->logErrorResponse($e);
        }
    }

    public function getActiveData($id = null, $with = [])
    {
        try {
            $query = $this->model::query()->with($with)->active();

            //check if this model using softDelete before apply softDelete functions
            if ($this->model->hasSoftDelete()  && (request('trashed') == 'true' || request('trashed') == '1')) {
                $query->withTrashed();
            }
            if ($id) {
                return $query->findOrFail($id);
            } else {
                return $query->get();
            }
        } catch (\Exception $e) {
            $this->logErrorResponse($e);
        }
    }

    public function storeOrUpdate($data, $id = null)
    {
        try {
            if ($id) {
                // Update
                return $this->model::findOrFail($id)->update($data);
            } else {
                // Create
                return $this->model::create($data);
            }
        } catch (\Exception $e) {
            $this->logErrorResponse($e);
        }
    }

    public function delete($id)
    {
        try {
            return $this->model::findOrfail($id)->delete();
        } catch (\Exception $e) {
            $this->logErrorResponse($e);
        }
    }

    public function logErrorResponse($e)
    {
        throw $e;
    }

    //get paginated data with status
    public function paginateWithStatus($query, $status = GlobalConstant::STATUS_ACTIVE)
    {
        //get default pagination from config if not provided
        $limit = request('per_page',ic_config('default_paginate'));

        //check if this model using softDelete before apply softDelete functions
        if ($this->model->hasSoftDelete()  && (request('trashed') == 'true' || request('trashed') == '1')) {
            $query->withTrashed();
        }

        //match works like switch case
        $query = match($status) {
            GlobalConstant::STATUS_ACTIVE => $query->active(),
            GlobalConstant::STATUS_INACTIVE => $query->inactive(),
            default => $query,
        };

        return $query->paginate($limit);
    }

    //get only trashed data
    public function getTrashedData($with = [])
    {
        //get default pagination from config if not provided
        $limit = request('per_page',ic_config('default_paginate'));
        return $this->model::query()->with($with)->onlyTrashed()->paginate($limit);
    }

    public function restore(int|string $ids)
    {
        return $this->model::query()
            ->onlyTrashed()
            ->whereIn('id', explode(',', $ids))
            ->restore();
    }

    public function forceDelete(int|string $ids)
    {
        return $this->model::query()
            ->onlyTrashed()
            ->whereIn('id', explode(',', $ids))
            ->forceDelete();
    }
}
