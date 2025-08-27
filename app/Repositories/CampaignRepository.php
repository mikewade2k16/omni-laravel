<?php

namespace App\Repositories;

use App\Models\Campaign;

class CampaignRepository
{
    public function list() 
    { 
        return Campaign::all(); 
    }

    public function store(array $data) 
    { 
        return Campaign::create($data); 
    }

    public function find($id) 
    { 
        return Campaign::findOrFail($id); 
    }

    public function update($id, array $data)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->update($data);
        return $campaign;
    }
    
    public function delete($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();
    }
}
