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

    public function getdata($id)
    {
        $file = File::findOrFail($id);
        $matters = Matter::all();

        $submatters = SubMatter::all();
        $countries = Country::all();
        $feeEarnerList = User::where('Client_ID', $file->Client_ID)->where('User_Role', '=',2)->get();

        return view('admin.file_opening_book.view', compact('file', 'feeEarnerList','countries', 'matters', 'submatters'));
    
    }

    public function create()
    {
        $countries = Country::all();
        $matters = Matter::all();
        $submatters = SubMatter::all();

        return view('admin.file_opening_book.create', compact('countries', 'matters', 'submatters'));
    }

    public function update_file_recode(FileRequest $request)
    {
     
        $data = $request->validated();
        foreach (['File_Date', 'Date_Of_Birth', 'Key_Date'] as $field) {
            if (!empty($data[$field])) {
                try {
                    $data[$field] = \Carbon\Carbon::parse($data[$field])->format('Y-m-d');
                } catch (\Exception $e) {
                    return back()->withErrors([$field => "The $field format is invalid."]);
                }
            }
        }
     
        $file_id = $request->File_ID;

        $file = File::find($file_id);
        if ($file) {
            $file->update($data);
            return redirect()->route('files.index')->with('success', 'File Updated successfully.');
        } else {
            return back()->withErrors(['File_ID' => 'File not found.']);
        }
    } //  
    
    
    public function store(FileRequest $request)
    {
        $data = $request->validated();

        foreach (['File_Date', 'Date_Of_Birth', 'Key_Date'] as $field) {
            if (!empty($data[$field])) {
                try {
                    $data[$field] = \Carbon\Carbon::parse($data[$field])->format('Y-m-d');
                } catch (\Exception $e) {
                    return back()->withErrors([$field => "The $field format is invalid."]);
                }
            }
        }


        // Add additional fields and save
        $user = Auth::user();

        $data['Client_ID'] = $user->Client_ID;

        $data['Created_By'] = Auth::id();
        $data['Created_On'] = now();

        $file = File::create($data);

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
