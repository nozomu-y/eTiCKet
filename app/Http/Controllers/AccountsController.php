<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Accounts Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'accounts/add';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function register(Request $request) {
        $validator = $this->validator($request->all());
        $validator->validate();

        $user = new User();
        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->password = Hash::make(config('app.default_user_password'));
        $user->role = 'member';
        $user->save();
        return redirect()->route('accounts')->with('success', __('message.accounts.add.success'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
        ]);
    }

    function index()
    {
        $users = User::All();
        $data = [];
        foreach ($users as $user) {
            $user_data = [];
            $user_data['id'] = $user->id;
            $user_data['name'] = $user->name;
            $user_data['username'] = $user->username;
            $user_data['role'] = $user->role;
            array_push($data, $user_data);
        }
        return view('accounts.list', ['users' => $data]);
    }
}
