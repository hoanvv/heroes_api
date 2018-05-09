<?php

namespace App\Http\Controllers\BackEnd\PackageOwner;

use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pos = User::where('role_id', 3)->get();
        return view('back-end.pages.package-owner.list', compact('pos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-end.pages.package-owner.add');
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
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|string|max:20',
        ];
        //Validate information from request
        $this->validate($request, $rules);
        //Solve data before save to database
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['role_id'] = 3;
        $user = User::create($data);

        // Send message that have created a new user
        session()->flash('message_success', 'You created a new user successfully');
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
        $po = User::findOrFail($id);

        return view('back-end.pages.package-owner.edit', compact('po'));
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
            'first_name' => 'string|max:191',
            'last_name' => 'string|max:191',
            'email' => 'string|email|max:191|unique:users',
            'phone' => 'string|max:20',
        ];
        $this->validate($request, $rules);

        $user = User::findOrFail($id);
        $user->fill($request->only([
            'last_name',
            'first_name',
            'email',
            'phone'
        ]));
        if($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        //Check that any fields have changed
        if($user->isClean()) {
            session()->flash('message_error', 'You need to specify a different value to update');
            return redirect()->back();
        }
        //Save updated profile
        $user->save();
        // Send message that have created a new user
        session()->flash('message_success', 'You updated a package owner successfully');
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
        //
    }

    public function BlockActivity($id)
    {
        $user = User::findOrFail($id);

        $user->blocked = (int)!$user->blocked;
        $user->save();

        if ($user->blocked) {
            $value = "This shipper is blocked";
        } else {
            $value = "This shipper is unblocked";
        }

        session()->flash('message_success', $value);
        return redirect()->back();
    }
}
