<?php

namespace App\Repositories;

use App\Models\Concession;

class ConcessionRepository implements ConcessionRepositoryInterface
{
    public function all()
    {
        return Concession::all();
    }

    public function find($id)
    {
        return Concession::findOrFail($id);
    }

    public function create(array $data)
    {
        return Concession::create($data);
    }

    public function update($id, array $data)
    {
        $concession = Concession::findOrFail($id);
        $concession->update($data);
        return $concession;
    }

    public function delete($id)
    {
        return Concession::destroy($id);
    }
}
