<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\Matter;
use App\Models\Country;
use App\Models\SubMatter;
use Illuminate\Http\Request;
use App\DataTables\FileDataTable;
use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function index(FileDataTable $dataTable)
    {

        return $dataTable->render('admin.file_opening_book.index');
    }

    public function view($id)
    {
        $file = File::findOrFail($id);
        $feeEarnerList = User::where('client_id', $file->client_id)->where('role', 'fee_earner')->get();

        return view('file.view', compact('file', 'feeEarnerList'));
    }

    public function create()
    {
        $countries = Country::all();
        $matters = Matter::all();
        $submatters = SubMatter::all();
        
        return view('admin.file_opening_book.create', compact('countries', 'matters', 'submatters'));
    }
    

    public function store(FileRequest $request)
    {
        $data = $request->validated();
        if (isset($data['File_Date'])) {
        //  dd($data['File_Date']);

            try {
                $data['File_Date'] = \Carbon\Carbon::createFromFormat('d-M-Y', $data['File_Date'])->format('Y-m-d');
            } catch (\Exception $e) {
                return back()->withErrors(['File_Date' => 'The File Date format is invalid.']);
            }
        }

        if (isset($data['Date_Of_Birth'])) {
            $data['Date_Of_Birth'] = \Carbon\Carbon::parse($data['Date_Of_Birth'])->format('Y-m-d');
        }

        if (isset($data['Key_Date'])) {
            $data['Key_Date'] = \Carbon\Carbon::parse($data['Key_Date'])->format('Y-m-d');
        }

        // Add additional fields and save
        $user = Auth::user();
        
        $data['Client_ID'] = $user->Client_ID;
        $data['Created_By'] = Auth::id();
        $data['Created_On'] = now();

        File::create($data);

        return redirect()->route('files.index')->with('success', 'File created successfully.');
    }

    public function destroy(Request $request)
{
    $id = $request->id; // Get the file ID
    $record = File::findOrFail($id);
    $record->delete();

    return response()->json([
        'success' => true,
        'message' => 'Record deleted successfully!'
    ]);
}

    
    public function updateStatus(Request $request)
    {
        $file = File::find($request->File_ID);
        if ($file) {
            $file->Status = $request->status;
            $file->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'File not found.']);
    }
  
   
    public function getFileData(Request $request)
{
    $fileId = $request->input('id');
    $fileData = File::find($fileId);

    if ($fileData) {
        return response()->json([
            'success' => true,
            'data' => $fileData
        ]);
    }

    return response()->json(['success' => false]);
}

    
    }
    


