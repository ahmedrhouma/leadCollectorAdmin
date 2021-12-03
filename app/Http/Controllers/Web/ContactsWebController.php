<?php

namespace App\Http\Controllers\Web;

use App\Helper\Countries;
use App\Models\Contacts;
use App\Models\Profiles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ContactsWebController extends Controller
{
    public function index(){
        return view('dashboard.contacts');
    }
    public function show(Contacts $contact){
        return response()->json([
            'success' => true,
            'data' => $contact
        ]);
    }
    public function paginate(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::eloquent(Contacts::query()->with('profiles'))
                ->addColumn('country', function($row){
                    return Countries::getByIso($row->country);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }
}
