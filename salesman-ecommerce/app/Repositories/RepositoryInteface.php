<?php

namespace App\Repositories;

interface RepositoryInteface 
{

    public function getAll();

    public function find($id);

    public function create(array $attr);
    
    public function insert(array $attr);
    
    public function update($id, array $attr);

    public function delete($id);

    public function getImg($path);

    public function upload($path,$image);
}