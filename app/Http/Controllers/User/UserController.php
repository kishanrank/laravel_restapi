<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json(['data' => $users], 200);
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['data' => $error->errors()->all()]);
        }

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = (new User())->generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return response()->json(['data' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json(['data' => $user], 200);
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
        $user = User::findOrFail($id);

        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['error' => $error->errors()->all()]);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = $user->generateVerificationCode();
            $user->email = $request->email;
        }

        if($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if($request->has('admin')) {
            if(!$user->isVerified()) {
                return response()->json(['error' => 'Only verified user can modify admin section.', 'code' => 409], 409);
            }
        }

        if(!$user->isDirty()) {
            return response()->json(['error' => 'You must enter something different.', 'code' => 422], 422);
        }

        $user->save();

        return response()->json(['data' => $user], 200);
        
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
}
