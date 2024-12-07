<?php

namespace App\Contracts;

interface BaseContract
{

    public function getAll();

    public function findById($id);

    public function store($request);

    public function update($request, $id);

    public function delete($id);

    public function cancel($request);

    public function stats($request);

    public function notify();
}
