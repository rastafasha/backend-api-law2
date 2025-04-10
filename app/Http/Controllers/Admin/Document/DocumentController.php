<?php

namespace App\Http\Controllers\Admin\Document;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Document\Document;
use App\Http\Controllers\Controller;
use App\Models\Appointment\Appointment;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\Document\DocumentCollection;
use App\Http\Resources\Appointment\AppointmentCollection;

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
            ->get();


        return response()->json([
            'code' => 200,
            'status' => 'Listar pubs',
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
        // $document = Appointment::findOrFail($request->user_id);

        $user_is_valid = Document::where("user_id", "<>", $request->user_id)->first();

        // if($user_is_valid){
        //     return response()->json([
        //         "message"=>403,
        //         "message_text"=> 'el Appointment ya existe'
        //     ]);
        // }

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
                'user_id' => $request->user_id,
                'name_file' => $name_file,
                'name_category' => $request->name_category,
                'size' => $size,
                'resolution' => $data ? $data[0] . "x" . $data[1] : NULL,
                'file' => $path,
                'type' => $extension,
            ]);
        }

        // error_log($clase);
        error_log($document);

        return response()->json(['document' => DocumentResource::make($document)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = Document::findOrFail($id);

        return response()->json([
            "document" => DocumentResource::make($document),
        ]);

    }

    public function showByUser($user_id)
    {
        $documents = Document::where("user_id", $user_id)->get();

        return response()->json([
            "documents" => DocumentCollection::make($documents),
        ]);


    }
    public function showByUserFiltered(Request $request)
    {
        $query = Document::query()
            ->when($request->user_id, function ($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            })
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
        $documents = Document::where("user_id", $user_id)
            ->where('name_category', $name_category)
            ->get();

        return response()->json([
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
        $Document = Document::findOrFail($id);
        $Document->update($request->all());

        return response()->json([
            'Document' => DocumentResource::make($Document)
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
        $document = Document::findOrFail($id);


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
    public function shareToClient(Request $request, $document_id, $client_id)
    {
        $document = Document::findOrFail($document_id);
        $user = auth()->user();

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
