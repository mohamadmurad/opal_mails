<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('company')->paginate();

        return view('user.index',compact('users'));
    }


    public function create(){

        $company = Company::all();
        return view('user.create',compact('company'));
    }

    public function store(StoreUserRequest $request)
    {

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'company_id' =>  $request->get('company_id'),
            'isAdmin' =>  $request->get('isAdmin'),
            'isManager' =>  $request->get('isManager'),
        ]);


        return Redirect::route('user.index')
            ->with('success','User Created successfully.');

    }


    public function show(Request $request, User $user){

        //return view('company.show',compact('company'));
    }


    public function edit(User $user){

        $company = Company::all();
        return view('user.edit',compact('user','company'));
    }


    public function update(Request $request , User $user){

        $company = Company::all()->pluck('id');


        $request->validate( [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' =>  ['nullable','string', new Password, 'confirmed'],
            'isManager' =>  'required|in:1,0',
            'isAdmin' => 'required|in:1,0',
            'company_id' => 'required'/*|in:' . $company*/,
        ]);


        if ($request['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            //$this->updateVerifiedUser($user, $request);
        } else {
            $user->forceFill([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => $user->password,
                'isManager' => $request['isManager'],
                'isAdmin' => $request['isAdmin'],
                'company_id' => $request['company_id'],
            ])->save();
        }

        $user->save();

        return Redirect::route('user.index')
            ->with('success','User Updated successfully.');

    }

    public function destroy(User $user){

        $user->delete();
        return Redirect::route('user.index')
            ->with('success','User Deleted successfully.');
    }


}
