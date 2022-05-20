<?php

namespace App\Repositories;

abstract class RepositoryEloquent implements RepositoryInteface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->_model = app()->make($this->getModel());
    }

    public function getAll()
    {
        return $this->_model->all();
    }

    public function find($id)
    {
        $result = $this->_model->find($id);

        return $result;
    }

    public function create(array $attributes)
    {
        return $this->_model->create($attributes);
    }

    public function insert(array $attributes) {
        return $this->_model->insert($attributes);
    }

    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if($result)
        {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if($result)
        {
            $result->delete();
            return true;
        }

        return false;
    }

    public function upload($path,$image){

        $imageName = time().$image->getClientOriginalName(); 
        $image->move(public_path('storage'.$path), $imageName);
        $path_image = config('filesystems.disks')['public']['url'].$path.'/'.$imageName;

        return $path_image;
    }

    public function getImg($path){

        $image = config('filesystems.disks')['public']['url'].$path;
        $pathimage = scandir(public_path('storage').$path);
        $nameimage = array_values(array_diff($pathimage, array('..', '.'))); 
        $ImgPath = $image.'/'.$nameimage[0] ; 
        return $ImgPath;
    }
}