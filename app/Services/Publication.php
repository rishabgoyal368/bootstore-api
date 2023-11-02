<?php

namespace App\Services;

use App\Models\Publication as ModelPublication;

trait Publication
{
    /**
     * Create or update a publication record.
     *
     * @param array $data
     * @return bool
     */
    public function createPublication($data)
    {
        ModelPublication::updateOrCreate(
            [
                'id' => $data['id'] ?? ''
            ],
            [
                'name' => $data['name'],
                'created_by' => $data['created_by']
            ]
        );
        return true;
    }

    /**
     * Delete a publication record by its ID.
     *
     * @param array $data
     * @return bool
     */
    public function deletePublication($data)
    {
        return ModelPublication::where('id', $data['id'])->delete();
    }

    /**
     * Get a list of publications based on filtering criteria.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPublication($data)
    {
        return ModelPublication::where(function ($query) use ($data) {
            if (@$data['created_by']) {
                $query->where('created_by', '=', $data['created_by']);
            }
        })->get();
    }
}
