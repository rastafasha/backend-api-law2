<?php

namespace App\Http\Controllers\Admin\Document;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\DocumentsUser;
use App\Models\SolicitudUser;
use App\Models\Document;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\Document\DocumentCollection;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents = Document::orderBy('created_at', 'DESC')
        -> with('documentsUsers')
            ->get();


        return response()->json([
            'code' => 200,
            'status' => 'Listar pubs',
            'documentsusers' => DocumentsUser::all(),
            "documents" => DocumentCollection::make($documents),
        ], 200);

    }


    // public function index(Request $request)
    // {

    //     $name_category = $request->name_category;
    //     $search_document = $request->search_document;
    //     $date_start = $request->date_start;
    //     $date_end = $request->date_end;

    //     $documents = Document::filterAdvanceDocument(
    //         $name_category,
    //         $search_document,
    //         $date_start,
    //         $date_end
    //     )
    //         ->paginate(10);
    //     return response()->json([
    //         "total" => $documents->total(),
    //         "documents" => DocumentCollection::make($documents)
    //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user_id = $request->user_id;
        $client_id = $request->client_id;

       if(!$user_id && !$client_id) {
            return response()->json([
                'message' => 'user_id or client_id is required',
                'code' => 422
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'name_category' => 'nullable|string|max:250',
            'user_id' => 'nullable|integer|exists:users,id',
            'client_id' => 'nullable|integer|exists:clients,id',
            'user_ids' => 'array',
            'user_ids.*' => 'integer|exists:users,id',
            'client_ids' => 'array',
            'client_ids.*' => 'integer|exists:clients,id',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        

        foreach ($request->file("files") as $key => $file) {
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $name_file = $file->getClientOriginalName();
            $data = null;
            if (in_array(strtolower($extension), ["jpeg", "bmp", "jpg", "png", ".pdf"])) {
                $data = getImageSize($file);

            }
            $path = Storage::putFile("documents", $file);

            $document = Document::create([
                // 'user_id' => $request->user_id,
                // 'client_id' => $request->client_id,
                'name_file' => $name_file,
                'name_category' => $request->name_category,
                'size' => $size,
                'resolution' => $data ? $data[0] . "x" . $data[1] : NULL,
                'file' => $path,
                'type' => $extension,
            ]);
            // Attach users and clients in documents_users pivot table
            if ($request->user_id) {
                DocumentsUser::create([
                    'document_id' => $document->id,
                    'user_id' => $request->user_id,
                ]);
                
            }

            if ($request->client_id) {
                DocumentsUser::create([
                    'document_id' => $document->id,
                    'client_id' => $request->client_id,
                ]);
                
            }
            //   DocumentsUser::create([
            //     'document_id' => $document->id,
            //     'user_id' => $request->user_id || null,
            //     'client_id' => $request->client_id || null,
            // ]);
        }

        


        return response()->json($document, 201);
        // return response()->json([
        //     "document" => DocumentResource::make($document),
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = Document::with('documentsUsers')->find($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        return response()->json([
            "document" => DocumentResource::make($document),
        ]);

    }

    public function showByUser($user_id)
    {
        $documentUsers = DocumentsUser::where("user_id", $user_id)
            ->where('user_id', $user_id)
            ->get();

        $documents = $documentUsers->map(function ($documentUser) {
            return $documentUser->document;
        });
        return response()->json([
            // "documents" => $documents,
            "documents" => DocumentCollection::make($documents),
        ]);


    }
    public function showByClient($client_id)
    {

        $documentUsers = DocumentsUser::where("client_id", $client_id)
            ->where('client_id', $client_id)
            ->get();
        $documents = $documentUsers->map(function ($documentUser) {
            return $documentUser->document;
        });
        return response()->json([
            // "documents" => $documents,
            "documents" => DocumentCollection::make($documents),
        ]);


    }



    public function showDocumentFiltered(Request $request)
    {
        $query = Document::query()
            ->when($request->user_id, function ($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            })
            // ->when($request->client_id, function ($q) use ($request) {
            //     return $q->where('client_id', $request->client_id);
            // })
            ->when($request->name_category, function ($q) use ($request) {
                return $q->where('name_category', $request->name_category);
            })
            ->when($request->search_document, function ($q) use ($request) {
                return $q->where('name_file', 'like', '%' . $request->search_document . '%');
            })
            ->when($request->created_at, function ($q) use ($request) {
                return $q->whereDate('created_at', $request->created_at);
            });

        $documents = $query->paginate(10);

        return response()->json([
            "total" => $documents->total(),
            "documents" => DocumentCollection::make($documents)
        ]);


    }


    public function showByCategory($user_id, $name_category)
    {
        $documentUsers = DocumentsUser::where("user_id", $user_id)
            ->whereHas('document', function ($query) use ($name_category) {
                $query->where('name_category', $name_category);
            })
            ->get();

        $documents = $documentUsers->map(function ($documentUser) {
            return $documentUser->document;
        });

        return response()->json([
            // "documents" => $documents,
            "documents" => DocumentCollection::make($documents),
        ]);
    }

    public function showByClientCategory($client_id, $name_category)
    {
        $documentUsers = DocumentsUser::where("client_id", $client_id)
            ->whereHas('document', function ($query) use ($name_category) {
                $query->where('name_category', $name_category);
            })
            ->get();

        $documents = $documentUsers->map(function ($documentUser) {
            return $documentUser->document;
        });

        return response()->json([
            // "documents" => $documents,
            "documents" => DocumentCollection::make($documents),
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);
        $document->update($request->all());

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
            \Log::info('client_ids array:', $request->input('client_ids'));
            foreach ($request->input('client_ids') as $clientId) {
                $created = DocumentsUser::create([
                    'document_id' => $document->id,
                    'client_id' => $clientId,
                ]);
                \Log::info('Created DocumentsUser:', ['id' => $created->id, 'client_id' => $clientId]);
            }
        }

        return response()->json([
            'Document' => DocumentResource::make($document)
        ]);
    }
    public function addFiles(Request $request)
    {
        $Document = Document::findOrFail($request->user_id);
        foreach ($request->file("files") as $key => $file) {
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $name_file = $file->getClientOriginalName();
            $data = null;
            if (in_array(strtolower($extension), ["jpeg", "bmp", "jpg", "png"])) {
                $data = getImageSize($file);

            }
            $path = Storage::putFile("documents", $file);

            $Document = Document::create([
                'user_id' => $request->user_id,
                'name_file' => $name_file,
                'size' => $size,
                'resolution' => $data ? $data[0] . "x" . $data[1] : NULL,
                'file' => $path,
                'type' => $extension,
            ]);
        }

        return response()->json(['Document' => DocumentResource::make($Document)]);

    }

    public function removeFiles($id)
    {
        $Document = Document::findOrFail($id);
        $Document->delete();

        return response()->json(["message" => 200]);

    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = Document::find($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        DocumentsUser::where('document_id', $document->id)->delete();

        // Delete related documents_users entries

        if ($document->avatar) {
            Storage::delete($document->avatar);
        }
        $document->delete();

        return response()->json([
            "message" => 200
        ]);
    }

    /**
     * Share document to client
     */
    public function shareToClient(Request $request)
    {
        $document = Document::findOrFail($request->document_id);
        $user = User::findOrFail($request->user_id);
        $client = Client::findOrFail($request->client_id);

        // Verificar que el usuario es dueño del documento
        if ($request->user_id != $user->id) {
            return response()->json([
                'message' => 'No tienes permiso para compartir este documento',
                'code' => 403
            ], 403);
        }

        if ($request->client_id != $client->id) {
            return response()->json([
                'message' => 'No existe este usuario',
                'code' => 403
            ], 403);
        }

        // Verificar relación usuario-cliente en SolicitudUser
        $relationExists = SolicitudUser::where('user_id', $user->id)
            ->where('client_id', $request->client_id)
            ->exists();

        if (!$relationExists) {
            return response()->json([
                'message' => 'No existe relación con este cliente',
                'code' => 404
            ], 404);
        }

        // Actualizar documento con client_id
        // $document->update([
        //     'client_id' => $request->client_id
        // ]);

        DocumentsUser::create([
            'document_id' => $request->document_id,
            'user_id' => $request->user_id,
            'client_id' => $request->client_id,
        ]);

        return response()->json([
            'message' => 'Documento compartido con el cliente exitosamente',
            'code' => 200,
            'document' => DocumentResource::make($document)
        ]);
    }

    public function shareGroupClientByNameCategory(Request $request, $document_id, $client_id, $category_name)
    {
        $document = Document::findOrFail($document_id);
        $user = auth()->user();
        $category = Category::where('name', $category_name)->first();
        $client = Client::where('id', $client_id)->first();
        $group = Group::where('category_id', $category->id)->first();
        $group_client = GroupClient::where('group_id', $group->id)->where('
        client_id', $client->id)->first();
        // Verificar que el usuario es dueño del documento
        if ($document->user_id != $user->id) {
            return response()->json([
                'message' => 'No tienes permiso para compartir este documento',
                'code' => 403
            ], 403);
        }
        // Verificar relación usuario-cliente en SolicitudUser
        $relationExists = SolicitudUser::where('user_id', $user->id)
            ->where('cliente_id', $client_id)
            ->exists();
        if (!$relationExists) {
            return response()->json([
                'message' => 'No existe relación con este cliente',
                'code' => 404
            ], 404);
        }

        // Actualizar documento con client_id
        $document->update([
            'client_id' => $client_id
        ]);
        return response()->json([
            'message' => 'Documento compartido con el cliente exitosamente',
            'code' => 200,
            'document' => DocumentResource::make($document)
        ]);



    }

    public function dowloadFile(Request $request, $document_id)
    {
        $document = Document::findOrFail($document_id);
        $user = auth()->user();
        $file = $document->file;
        $path = storage_path('app/public/' . $file);

    }
}
