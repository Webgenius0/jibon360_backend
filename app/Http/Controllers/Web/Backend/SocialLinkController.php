<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\SocialLink;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use Kreait\Firebase\Contract\Database;
use Exception;
class SocialLinkController extends Controller
{
     public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SocialLink::latest();
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
                    $html .= '<a href="' . route('social-link.edit', $data->id).'" class="btn btn-sm btn-success" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $html .= '<a href="#" onclick="showDeleteConfirm('.$data->id.')" type="button"class="btn btn-danger btn-sm text-white" title="Delete" readonly><i class="bi bi-trash"></i></a>';
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make();
        }
        return view('backend.layout.sociallink.index');
    }

    public function create()
    {
        $SocialLink = SocialLink::where( 'status', '1' )->orderBy( 'id', 'desc' )->get();
        return view('backend.layout.sociallink.create', compact('SocialLink'));
    }

    public function store(Database $database, Request $request)
    {
        
        $request->validate([
            'name'  => 'required|min:3|max:255',
            'url'   => 'required|url',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $SocialLink = new SocialLink();
            $SocialLink->name = $request->name;
            $SocialLink->url = $request->url;
            if (!empty($request['icon'])) {
                $imageName = 'icon_' . Str::random(10);
                $SocialLink->icon = Helper::fileUpload($request['icon'], 'social_link', $imageName);
            }
            $SocialLink->save();

            // firebase noitification sender
            /* try {
                $data = [
                    'id' => $SocialLink->id,
                    'name' => $SocialLink->name,
                    'type' => 'Social Link',
                    'status' => '1',
                ];
                $store = $database->getReference('notifications')->push($data);
            } catch (Exception $e) {
                flash()->error($e->getMessage());
            } */

            flash()->success('Social Link Added');
            return redirect()->route('social-link.index');
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function show(SocialLink $SocialLink, $id)
    {
        return view('backend.layout.sociallink.edit', [
            'SocialLink' => SocialLink::find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('backend.layout.sociallink.edit', [
            'SocialLink' => SocialLink::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialLink $SocialLink)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'url' => 'required|url',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $SocialLink = SocialLink::find($request->id);
            $SocialLink->name = $request->name;
            $SocialLink->url = $request->url;
            if(!empty( $request['icon'])){
                if(!empty($SocialLink->image && File::exists(public_path( '/' ) . $SocialLink->image ))){
                    @unlink( public_path( '/' ) . $SocialLink->icon );  
                }
                $imageName = 'icon_'.Str::random(10);
                $icon = Helper::fileUpload( $request->icon, 'social_link', $imageName);
                $SocialLink->icon = $icon;
            }
            $SocialLink->save();
            flash()->success('Social Link Updated');
            return redirect()->route('social-link.index');
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
                $SocialLink = SocialLink::findOrFail($id);
                $SocialLink->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Social Link Deleted Successfully.',
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Social Link Not Deleted because it has posts. Please delete all posts related to this Social Link first.',
                ]);
            }
        }
    }

    public function status( $id ) {
        $data = SocialLink::where( 'id', $id )->first();
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
