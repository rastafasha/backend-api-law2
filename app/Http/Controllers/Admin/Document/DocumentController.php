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
        $documents  = Document::orderBy('created_at', 'DESC')
        ->get();


        return response()->json([
            'code' => 200,
            'status' => 'Listar pubs',
            "documents" => DocumentCollection::make($documents ),
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

        foreach($request->file("files") as $key=>$file){
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $name_file = $file->getClientOriginalName();
            $data = null;
            if(in_array(strtolower($extension), ["jpeg", "bmp","jpg","png",".pdf" ])){
                $data = getImageSize($file);
                
            }
            $path = Storage::putFile("documents", $file);

            $document = Document::create([
                'user_id' =>$request->user_id,
                'name_file' =>$name_file,
                'name_category' =>$request->name_category,
                'size' =>$size,
                'resolution' =>$data ? $data[0]."x".$data[1]: NULL,
                'file' =>$path,
                'type'  =>$extension,
            ]);
        }

        // error_log($clase);
        error_log($document);

        return response()->json([ 'document'=> DocumentResource::make($document)]);
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
            ->when($request->user_id, function($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            })
            ->when($request->name_category, function($q) use ($request) {
                return $q->where('name_category', $request->name_category);
            })
            ->when($request->name_file, function($q) use ($request) {
                return $q->where('name_file', $request->name_file);
            })
            ->when($request->search_document, function($q) use ($request) {
                return $q->where('name_file', 'like', '%'.$request->search_document.'%');
            })
            ->when($request->created_at, function($q) use ($request) {
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
        $Document->update($request ->all());

        return response()->json([
            'Document'=> DocumentResource::make($Document)
        ]);
    }
    public function addFiles(Request $request)
    {
        $Document = Document::findOrFail($request->user_id);
        foreach($request->file("files") as $key=>$file){
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $name_file = $file->getClientOriginalName();
            $data = null;
            if(in_array(strtolower($extension), ["jpeg", "bmp","jpg","png"])){
                $data = getImageSize($file);
                
            }
            $path = Storage::putFile("documents", $file);

            $Document = Document::create([
                'user_id' =>$request-> user_id,
                'name_file' =>$name_file,
                'size' =>$size,
                'resolution' =>$data ? $data[0]."x".$data[1]: NULL,
                'file' =>$path,
                'type'  =>$extension,
            ]);
        }

        return response()->json([ 'Document'=> DocumentResource::make($Document)]);

    }

    public function removeFiles($id)
    {
        $Document = Document::findOrFail($id);
        $Document->delete();

        return response()->json([ "message"=> 200]);

    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);

       
        if($document->avatar){
            Storage::delete($document->avatar);
        }
        $document->delete();

        return response()->json([
            "message"=> 200
        ]);
    }
}
