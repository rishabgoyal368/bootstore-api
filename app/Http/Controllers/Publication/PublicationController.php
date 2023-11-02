<?php

namespace App\Http\Controllers\Publication;

use App\Http\Controllers\Controller;
use App\Services\Publication;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class PublicationController
 *
 * The PublicationController class is a controller class in a PHP application that handles CRUD operations for publications.
 * It uses the Publication trait to reuse common publication-related methods.
 */
class PublicationController extends Controller
{
    use Publication;

    /**
     * Retrieves publications based on the user's role.
     * If the user is an admin, all publications are returned.
     * Otherwise, only publications created by the user are returned.
     *
     * @param Request $request The request object.
     * @return JsonResponse The JSON response containing the publications.
     */
    public function index(Request $request): JsonResponse
    {
        $userId = $request->header('user_id');
        $user = User::find($userId);

        $data = [
            'created_by' => $user->type === 'admin' ? '' : $userId
        ];

        return response()->json(['success' => true, 'data' => $this->getPublication($data)], 200);
    }

    /**
     * Adds a new publication.
     * Validates the request data and creates the publication using the createPublication method from the Publication trait.
     *
     * @param Request $request The request object.
     * @return JsonResponse The JSON response indicating the success of the operation.
     */
    public function add(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'id' => 'nullable|exists:publications,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->merge(['created_by' => $request->header('user_id')]);
        $this->createPublication($request->all());

        return response()->json(['success' => true], 200);
    }

    /**
     * Deletes a publication.
     * Validates the request data and deletes the publication using the deletePublication method from the Publication trait.
     *
     * @param Request $request The request object.
     * @return JsonResponse The JSON response indicating the success of the operation.
     */
    public function delete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:publications,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->deletePublication($request->all());

        return response()->json(['success' => true], 200);
    }
}
