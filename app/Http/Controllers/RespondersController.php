<?php

namespace App\Http\Controllers;

use App\Helper\Countries;
use App\Models\Contacts;
use App\Models\Questions;
use App\Models\Responders;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RespondersController extends Controller
{
    public function index(){
        return view('dashboard.responders');
    }
    public function paginate(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::eloquent(Responders::query()->with('questions')->withCount('channels'))
                ->addColumn('destoryUrl', function($row){
                    return route('responders.destroy',['responder'=>$row->id]);
                })
                ->make(true);
        }
    }
    public function store(Request $request){
        dd($request->questions);
        $responder = Responders::create(['name'=>$request->name,'type'=>$request->type,'status' => 1,'account_id'=>Auth()->user()->account->id]);
        foreach ($request->questions as $key => $question){
            $data = [];
            if ($question['name'] == "message"){
                $key++;
                $data['message'] = $question['value'];
            }
            if ($request->questions[$key]['name'] == "response"){
                $key++;
                $data['response'] = 1;
            }else{
                $data['response'] = 0;
            }
            if ($request->questions[$key+2]['name'] == "field"){
                $data['id_field'] = $request->questions[$key+2]['value'];
            }
            if ($request->questions[$key+3]['name'] == "order"){
                $data['order'] = $request->questions[$key+3]['value'];
            }
            $data['responder_id']=$responder->id;
            Questions::create($data);
        }
        $responder->loadCount('channels');
        return response()->json([
           'success' => $responder?true:false,
           'data' => $responder,
        ]);
    }
    public function destroy(Request $request,Responders $responder){
        return response()->json([
            'success' => $responder->delete(),
        ]);
    }
}
