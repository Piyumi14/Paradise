<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\Auth;
use App\Contracts\MainRepositoryInterface;
use Illuminate\Contracts\Container\Container as App;
use Illuminate\Support\Facades\Storage;

abstract class MainRepository implements MainRepositoryInterface
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();


    /**
     * @return mixed
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        return $this->model = $model;
    }


    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        try {
            $data['row_version'] = date('YmdHis');
            return $this->model->create($data);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    /**
     * @param array $data values to be updated
     * @param mixed $id comparing value
     * @param string $attribute column name
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        //        $this->model->where($attribute, '=', $id)->update($data);
        $obj = $this->model->find($id);

        /*if($obj == null) {
            return ['row_version_error' => true, 'type' => 'delete'];
        }
        if($data['row_version'] <> '') {
            if($data['row_version'] <> $obj->row_version) {
                return ['row_version_error' => true, 'type' => 'update'];
            }
        }*/

        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $obj->{$key} = $value;
            }
            $obj->row_version = date('YmdHis');
            $obj->save();
        }
        return $this->model->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id, $row_version = '')
    {
        $obj = $this->model->find($id);
        $obj->deleted_by = Auth::user()->user['user_id'];
        $obj->save();
        /*if($obj == null) {
            return ['row_version_error' => true, 'type' => 'delete'];
        }
        if($row_version <> '') {
            if($row_version <> $obj->row_version) {
                return ['row_version_error' => true, 'type' => 'update'];
            }
        }*/
        return $this->model->destroy($id);
    }

    public function deleteByColumn($columnName, $columnValue, $row_version = '')
    {
        $obj = $this->model->where($columnName, '=', $columnValue);
        if ($obj) {
            $obj->update([
                'deleted_by' =>  Auth::id()
            ]);
        }
        /*if($obj == null) {
            return ['row_version_error' => true, 'type' => 'delete'];
        }
        if($row_version <> '') {
            if($row_version <> $obj->row_version) {
                return ['row_version_error' => true, 'type' => 'update'];
            }
        }*/
        return $obj->delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function orderBy($column, $order = 'asc')
    {
        return $this->model->orderBy($column, $order);
    }


    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function where($whereArr, $first = false, $columns = array('*'), $pluckColumn = null)
    {
        if ($first) {
            return $this->model->select($columns)->where($whereArr)->first();
        } elseif ($pluckColumn) {
            return $this->model->select($columns)->where($whereArr)->pluck($pluckColumn);
        } else {
            return $this->model->select($columns)->where($whereArr)->get();
        }
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    public function deleteFilesFromStorage($path, $file)
    {
        return Storage::delete($path . "/" . $file);
    }

    /**
     * Begin querying a model with eager loading.
     *
     * @param  array|string  $relations
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function withRelationshipQuery($withArray)
    {
        $withArr = [];
        foreach ($withArray as $relationship => $with) {
            $withArr[$relationship] = function ($query) use ($with) {
                $query->select($with['select']);
                if (!empty($with['where'])) {
                    $query->where($with['where']);
                }
                if (!empty($with['without'])) {
                    $query->without($with['without']);
                }
                if (!empty($with['withArray'])) {
                    $query->with($this->withRelationshipQuery($with['withArray']));
                }
            };
        }

        return $withArr;
    }
}
