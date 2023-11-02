<?php

namespace App\Services;

use App\Models\Book as ModelsBook;

trait Book
{
    /**
     * Create or update a book record.
     *
     * @param array $data
     * @return bool
     */
    public function createBook($data)
    {
        ModelsBook::updateOrCreate(
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
     * Delete a book record by its ID.
     *
     * @param array $data
     * @return bool
     */
    public function deleteBook($data)
    {
        return ModelsBook::where('id', $data['id'])->delete();
    }

    /**
     * Get a list of books based on filtering criteria.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBook($data)
    {
        return ModelsBook::where(function ($query) use ($data) {
            if (@$data['created_by']) {
                $query->where('created_by', '=', $data['created_by']);
            }
        })->get();
    }
}
