<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

class EmergencyContactController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = EmergencyContact::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn( 'image', function ( $data ) {
                    if ( $data->icon == null ) {
                        return '<img style="width: 25px;" src="' . asset('default/logo.png') . '">';
                    } else {
                        return '<img style="width: 25px;" src="' . asset($data->icon) . '">';
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
                    $status .='</label></div>';
                    return $status;
                })
                ->addColumn('action', function ($data) {
                    $html = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">';
                    $html .= '<a href="' . route('emergency-contacts.edit', $data->id).'" class="btn btn-sm btn-success" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $html .= '<a href="#" onclick="showDeleteConfirm('.$data->id.')" type="button"class="btn btn-danger btn-sm text-white" title="Delete" readonly><i class="bi bi-trash"></i></a>';
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make();
        }
        return view('backend.layout.emergency_contacts.index');
    }

    public function create()
    {
        $emergencyContact = EmergencyContact::where( 'status', '1' )->orderBy( 'id', 'desc' )->get();
        return view('backend.layout.emergency_contacts.create', compact('emergencyContact'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => 'required|min:3|max:20|unique:emergency_contacts,phone',
            'location' => 'required|min:3|max:255',
        ]);
        try {
            $emergencyContact = new EmergencyContact();
            $emergencyContact->phone = $request->phone;
            $emergencyContact->name = $request->name;
            $emergencyContact->location = $request->location;

            if (!empty($request['icon'])) {
                $iconName = 'icon_' . Str::random(10);
                $emergencyContact->icon = Helper::fileUpload($request['icon'], 'emergency_contacts', $iconName);
            }

            $emergencyContact->save();
            flash()->success('Emergency Contact Added');
            return redirect()->route('emergency-contacts.index');
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function show(EmergencyContact $emergencyContact)
    {
        return view('backend.layout.emergency_contacts.edit', [
            'emergencyContact' => EmergencyContact::find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('backend.layout.emergency_contacts.edit', [
            'emergencyContact' => EmergencyContact::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmergencyContact $emergencyContact)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'required|min:3|max:255',
        ]);
        try {
            $emergencyContact = EmergencyContact::find($request->id);
            $emergencyContact->name = $request->name;
            $emergencyContact->location = $request->location;

            if(!empty( $request['icon'])){
                if(!empty($emergencyContact->icon && File::exists(public_path( '/' ) . $emergencyContact->icon ))){
                    @unlink( public_path( '/' ) . $emergencyContact->icon );  
                }
                $iconName = 'icon_'.Str::random(10);
                $icon = Helper::fileUpload( $request->icon, 'emergency_contacts', $iconName);
                $emergencyContact->icon = $icon;
            }

            $emergencyContact->save();
            flash()->success('Emergency Contact Updated');
            return redirect()->route('emergency-contacts.index');
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
            $EmergencyContact = EmergencyContact::findOrFail( $id );
            if ( $EmergencyContact->icon != null ) {
                if (File::exists($EmergencyContact->icon)) {
                    File::delete($EmergencyContact->icon);
                }
            }
            $EmergencyContact->delete();
            return response()->json( [
                'success' => true,
                'message' => 'Book Deleted Successfully.',
            ] );
        }
        return redirect()->back();
    }

    public function status( $id ) {
        $data = EmergencyContact::where( 'id', $id )->first();
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
