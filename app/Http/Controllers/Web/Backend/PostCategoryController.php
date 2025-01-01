<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use Kreait\Firebase\Contract\Database;
use Exception;

class PostCategoryController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PostCategory::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn( 'image', function ( $data ) {
                    if ( $data->image == null ) {
                        return '<img style="width: 25px;" src="' . asset('default/logo.png') . '">';
                    } else {
                        return '<img style="width: 25px;" src="' . asset($data->image) . '">';
                    }
                })
                ->addColumn( 'status', function ( $data ) {
                    $status = ' <div class="form-check form-switch d-flex">';
                    $status .= ' <input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input d-none" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';
                    if ( $data->status == 1 ) {
                        $status .= "checked";
                    }
                    $status .= '>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" for="customSwitch">';
                    if ($data->status == 1) {
                        $status .= "<img style='width: 20px;' src='" . asset('default/on.png') . "'>";
                    }else{
                        $status .= "<img style='width: 20px;' src='" . asset('default/off.png') . "'>";
                    }
                    $status .= '</label></div>';
                    return $status;
                })
                ->addColumn('action', function ($data) {
                    $html = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">';
                    $html .= '<a href="' . route('post-category.edit', $data->id).'" class="btn btn-sm btn-success" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $html .= '<a href="#" onclick="showDeleteConfirm('.$data->id.')" type="button"class="btn btn-danger btn-sm text-white" title="Delete" readonly><i class="bi bi-trash"></i></a>';
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make();
        }
        return view('backend.layout.post_category.index');
    }

    public function create()
    {
        $PostCategory = PostCategory::where( 'status', '1' )->orderBy( 'id', 'desc' )->get();
        return view('backend.layout.post_category.create', compact('PostCategory'));
    }

    public function store(Database $database, Request $request)
    {
        $request->validate([
            'name'  => 'required|min:3|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $PostCategory = new PostCategory();
            $PostCategory->name = $request->name;
            if (!empty($request['image'])) {
                $imageName = 'image_' . Str::random(10);
                $PostCategory->image = Helper::fileUpload($request['image'], 'post_category', $imageName);
            }
            $PostCategory->save();

            // firebase noitification sender
            /* try {
                $data = [
                    'id' => $PostCategory->id,
                    'name' => $PostCategory->name,
                    'type' => 'Post Category',
                    'status' => '1',
                ];
                $store = $database->getReference('notifications')->push($data);
            } catch (Exception $e) {
                flash()->error($e->getMessage());
            } */

            flash()->success('Post Category Added');
            return redirect()->route('post-category.index');
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function show(PostCategory $PostCategory, $id)
    {
        return view('backend.layout.post_category.edit', [
            'PostCategory' => PostCategory::find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('backend.layout.post_category.edit', [
            'PostCategory' => PostCategory::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PostCategory $PostCategory)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $PostCategory = PostCategory::find($request->id);
            $PostCategory->name = $request->name;
            if(!empty( $request['image'])){
                if(!empty($PostCategory->image && File::exists(public_path( '/' ) . $PostCategory->image ))){
                    @unlink( public_path( '/' ) . $PostCategory->image );  
                }
                $imageName = 'image_'.Str::random(10);
                $image = Helper::fileUpload( $request->image, 'post_category', $imageName);
                $PostCategory->image = $image;
            }
            $PostCategory->save();
            flash()->success('Post Category Updated');
            return redirect()->route('post-category.index');
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            return redirect()->back();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            try {
                $PostCategory = PostCategory::findOrFail($id);
                $PostCategory->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Category Deleted Successfully.',
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category Not Deleted because category has posts. Please delete all posts related to this category first.',
                ]);
            }
        }
    }

    public function status( $id ) {
        $data = PostCategory::where( 'id', $id )->first();
        if ( $data->status == 1 ) {
            $data->status = '0';
            $data->save();
            return response()->json( [
                'success' => false,
                'message' => 'Unpublished Successfully.',
            ] );
        } else {
            $data->status = '1';
            $data->save();
            return response()->json( [
                'success' => true,
                'message' => 'Published Successfully.',
            ] );
        }
    }
}
