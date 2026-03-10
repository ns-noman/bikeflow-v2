<?php

namespace App\Http\Controllers\backend;

use App\Models\BikeService;
use App\Models\BikeServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class BikeServiceController extends Controller
{
    protected $breadcrumb;
    public function __construct(){$this->breadcrumb = ['title'=>'Bike Services'];}
    public function index()
    {
        $data['breadcrumb'] = $this->breadcrumb;
        return view('backend.bike-services.index', compact('data'));
    }
    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = BikeService::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['breadcrumb'] = $this->breadcrumb;
        $data['categories'] = BikeServiceCategory::where('status', 1)->select('id','name')->get()->toArray();
        return view('backend.bike-services.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bike_service_category_id' => 'required|integer|exists:bike_service_categories,id',
            'name' => 'required|string|max:255',
            'trade_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:0,1'
        ]);

        try {

            $data = $request->all();
            $data['trade_price'] = $data['trade_price'] ?? 0;

            BikeService::create($data);

            return redirect()->route('bike-services.index')
                ->with('alert', [
                    'messageType' => 'success',
                    'message' => 'Data Inserted Successfully!'
                ]);

        } catch (Exception $e) {

            return redirect()->back()
                ->withInput()
                ->with('alert', [
                    'messageType' => 'danger',
                    'message' => 'Something went wrong!'
                ]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bike_service_category_id' => 'required|integer|exists:bike_service_categories,id',
            'name' => 'required|string|max:255',
            'trade_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:0,1'
        ]);

        try {

            $data = $request->all();
            $data['trade_price'] = $data['trade_price'] ?? 0;

            BikeService::findOrFail($id)->update($data);

            return redirect()->route('bike-services.index')
                ->with('alert', [
                    'messageType' => 'success',
                    'message' => 'Data Updated Successfully!'
                ]);

        } catch (Exception $e) {

            return redirect()->back()
                ->withInput()
                ->with('alert', [
                    'messageType' => 'danger',
                    'message' => 'Something went wrong!'
                ]);
        }
    }
    
 
    public function list(Request $request)
    {
        $query = BikeService::join('bike_service_categories', 'bike_service_categories.id', '=', 'bike_services.bike_service_category_id');
        if(!$request->has('order')) $query = $query->orderBy('id','desc');
        $query = $query->select('bike_services.*', 'bike_service_categories.name as cat_name');
        return DataTables::of($query)->make(true);
    }

}
