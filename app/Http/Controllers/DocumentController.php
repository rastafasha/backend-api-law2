<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents.
     */
    public function index(Request $request)
    {
        $query = $request->input('query', '');
        $documents = Document::search($query);
        return response()->json($documents);
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_category' => 'nullable|string|max:250',
            'name_file' => 'required|string|max:250',
            'size' => 'required|string|max:50',
            'resolution' => 'nullable|string|max:50',
            'file' => 'required|string|max:250',
            'type' => 'required|string|max:50',
            'user_ids' => 'array',
            'user_ids.*' => 'integer|exists:users,id',
            'client_ids' => 'array',
            'client_ids.*' => 'integer|exists:clients,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $document = Document::create($request->only([
            'name_category',
            'name_file',
            'size',
            'resolution',
            'file',
            'type',
        ]));

        // Attach users and clients in documents_users pivot table
        if ($request->has('user_ids')) {
            foreach ($request->input('user_ids') as $userId) {
                DocumentsUser::create([
                    'document_id' => $document->id,
                    'user_id' => $userId,
                ]);
            }
        }

        if ($request->has('client_ids')) {
            foreach ($request->input('client_ids') as $clientId) {
                DocumentsUser::create([
                    'document_id' => $document->id,
                    'client_id' => $clientId,
                ]);
            }
        }

        return response()->json($document, 201);
    }

    /**
     * Display the specified document.
     */
    public function show($id)
    {
        $document = Document::with('documentsUsers')->find($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        return response()->json($document);
    }

    /**
     * Update the specified document in storage.
     */
    public function update(Request $request, $id)
    {
        $document = Document::find($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name_category' => 'nullable|string|max:250',
            'name_file' => 'required|string|max:250',
            'size' => 'required|string|max:50',
            'resolution' => 'nullable|string|max:50',
            'file' => 'required|string|max:250',
            'type' => 'required|string|max:50',
            'user_ids' => 'array',
            'user_ids.*' => 'integer|exists:users,id',
            'client_ids' => 'array',
            'client_ids.*' => 'integer|exists:clients,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $document->update($request->only([
            'name_category',
            'name_file',
            'size',
            'resolution',
            'file',
            'type',
        ]));

        // Update documents_users pivot table
        // Remove existing relations
        DocumentsUser::where('document_id', $document->id)->delete();

        // Attach new users and clients
        if ($request->has('user_ids')) {
            foreach ($request->input('user_ids') as $userId) {
                DocumentsUser::create([
                    'document_id' => $document->id,
                    'user_id' => $userId,
                ]);
            }
        }

        if ($request->has('client_ids')) {
            foreach ($request->input('client_ids') as $clientId) {
                DocumentsUser::create([
                    'document_id' => $document->id,
                    'client_id' => $clientId,
                ]);
            }
        }

        return response()->json($document);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy($id)
    {
        $document = Document::find($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        // Delete related documents_users entries
        DocumentsUser::where('document_id', $document->id)->delete();

        $document->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    }
}
