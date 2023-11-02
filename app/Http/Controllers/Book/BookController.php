<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Services\Book;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    use book;

    /**
     * Retrieves books based on the user's role.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request): JsonResponse
    {
        $data = [];
        $userId = $request->header('user_id');
        $user = User::find($userId);

        if ($user && in_array($user->type, ['author', 'admin'])) {
            $data['created_by'] = $userId;
        }

        return response()->json(['success' => true, 'data' => $this->getBook($data)], 200);
    }

    /**
     * Adds a new book.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'id' => 'nullable|exists:books,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->merge(['created_by' => $request->header('user_id')]);
        $this->createBook($request->all());

        return response()->json(['success' => true], 200);
    }

    /**
     * Deletes a book.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:books,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->deleteBook($request->all());

        return response()->json(['success' => true], 200);
    }
}
