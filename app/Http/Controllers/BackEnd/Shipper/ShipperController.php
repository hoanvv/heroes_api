<?php

namespace App\Http\Controllers\BackEnd\Shipper;

use App\Entities\Role;
use App\Entities\Shipper;
use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShipperController extends Controller
{
    public function index()
    {
        $shippers = Shipper::with('user')->get();
        return view('back-end.pages.shipper.list', compact('shippers'));
    }

    public function create()
    {
        return view('back-end.pages.shipper.add');
    }

    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|string|max:20',
            'identity_card' => 'required|numeric|digits_between:9,20',
            'avatar' => 'image'
        ];
        //Validate information from request
        $this->validate($request, $rules);
        //Solve data before save to database
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['role_id'] = 2;
        $user = User::create($data);

        $data['user_id'] = $user->id;
        $data['avatar'] = $request->file('avatar')->store('public/avatars');
        //store information to db
        $shipper = Shipper::create($data);
        // Send message that have created a new user
        session()->flash('message_success', 'You created a new user successfully');
        //redirect to back
        return redirect()->back();
    }

    public function edit($id)
    {
        $shipper = Shipper::with('user')->findOrFail($id);

        return view('back-end.pages.shipper.edit', compact('shipper'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'first_name' => 'string|max:191',
            'last_name' => 'string|max:191',
            'email' => 'string|email|max:191|unique:users',
            'phone' => 'string|max:20',
            'identity_card' => 'numeric|digits_between:9,20',
            'avatar' => 'image'
        ];
        $this->validate($request, $rules);

        $shipper = Shipper::findOrFail($id);

        $shipper->fill($request->only([
            'identity_card'
        ]));

        $user = $shipper->user;
        $user->fill($request->only([
            'last_name',
            'first_name',
            'email',
            'phone'
        ]));
        if($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        if($request->hasFile('avatar')) {
            $shipper->avatar = $request->file('avatar')->store('public/avatars');
//            dd($user);
        }
        //Check that any fields have changed
        if($user->isClean()) {
            session()->flash('message_error', 'You need to specify a different value to update');
            return redirect()->back();
        }
        //Save updated profile
        $shipper->save();
        $user->save();
        // Send message that have created a new user
        session()->flash('message_success', 'You updated a new user successfully');
        //redirect to back
        return redirect()->back();
    }

    public function delete($id)
    {

    }
}
