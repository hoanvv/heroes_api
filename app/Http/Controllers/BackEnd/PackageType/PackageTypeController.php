<?php

namespace App\Http\Controllers\BackEnd\PackageType;

use App\Entities\PackageType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packageTypes = PackageType::all();
        return view('back-end.pages.package-type.list', compact('packageTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-end.pages.package-type.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:191',
            'description' => 'string',
            'optional_package' => 'required|integer',
            'price' => 'required|integer',
            'start_weight' => 'required|integer',
            'end_weight' => 'required|integer',
        ];
        //Validate information from request
        $this->validate($request, $rules);
        //Solve data before save to database
        $data = $request->all();

        $user = PackageType::create($data);

        // Send message that have created a new user
        session()->flash('message_success', 'You created a new package type successfully');
        //redirect to back
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $packageType = PackageType::findOrFail($id);

        return view('back-end.pages.package-type.edit', compact('packageType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:191',
            'optional_package' => 'required|integer',
            'price' => 'required|integer',
            'start_weight' => 'required|integer',
            'end_weight' => 'required|integer',
        ];

        $this->validate($request, $rules);

        $obj = PackageType::findOrFail($id);
        $obj->fill($request->only([
            'name',
            'description',
            'optional_package',
            'price',
            'start_weight',
            'end_weight'
        ]));

        //Check that any fields have changed
        if($obj->isClean()) {
            session()->flash('message_error', 'You need to specify a different value to update');
            return redirect()->back();
        }
        //Save updated profile
        $obj->save();
        // Send message that have created a new user
        session()->flash('message_success', 'You updated a package type successfully');
        //redirect to back
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pt = PackageType::findOrFail($id);
        $pt->delete();
        session()->flash('message_success', 'You deleted a package type successfully');
        return redirect()->back();
    }
}
