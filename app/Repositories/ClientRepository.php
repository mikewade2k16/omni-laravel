<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository
{
    public function list() 
    { 
        return Client::all(); 
    }

    public function store(array $data) 
    { 
        return Client::create($data); 
    }

    public function find($id) 
    { 
        return Client::findOrFail($id); 
    }

    public function update($id, array $data)
    {
        $client = Client::findOrFail($id);
        $client->update($data);
        return $client;
    }
    
    public function delete($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
    }
}