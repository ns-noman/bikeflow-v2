<?php

namespace App\Http\Controllers\backend;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Str;
class BrandController extends Controller
{
    protected $breadcrumb;
    public function __construct(){$this->breadcrumb = ['title'=>'Brands'];}
    public function index()
    {
        $data['breadcrumb'] = $this->breadcrumb;
        return view('backend.brands.index', compact('data'));
    }
    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Brand::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['breadcrumb'] = $this->breadcrumb;
        return view('backend.brands.create-or-edit',compact('data'));
    }
    
    public function store(Request $request)
    {
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->imgUpload($request->file('logo'));
        }

        Brand::create($data);

        return redirect()->route('brands.index')
            ->with('alert', [
                'messageType' => 'success',
                'message' => 'Data Inserted Successfully!'
            ]);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->imgUpload($request->file('logo'), $id);
        }

        $brand->update($data);

        return redirect()->route('brands.index')
            ->with('alert', [
                'messageType' => 'success',
                'message' => 'Brand Updated Successfully!'
            ]);
    }

    public function imgUpload($img, $id = null)
    {
        $img_name = Str::uuid() . '.' . $img->getClientOriginalExtension();

        $path = public_path('uploads/brands');
        $img->move($path, $img_name);

        if ($id) {
            $brand = Brand::find($id);

            if ($brand && $brand->logo && file_exists($path . '/' . $brand->logo)) {
                unlink($path . '/' . $brand->logo);
            }
        }

        return $img_name;
    }
 
    public function list(Request $request)
    {
        $query = Brand::query();
        if(!$request->has('order')) $query = $query->orderBy('id','desc');
        return DataTables::of($query)->make(true);
    }

}
