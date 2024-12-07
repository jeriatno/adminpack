<?php

namespace App\Http\Controllers\Auth;

use Alert;
use App\Models\Services;
use App\User;
use Backpack\Base\app\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class MyAccountController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->middleware(backpack_middleware());
    }

    public function getAccountInfoForm()
    {
        $this->data['title'] = trans('backpack::base.my_account');
        $this->data['user'] = $this->guard()->user();


        return view('auth.account.update_info', $this->data);
    }

    public function postAccountInfoForm(Request $request)
    {

        $result = $this->guard()->user()->update($request->except(['_token']));

        if ($result) {
            Alert::success(trans('backpack::base.account_updated'))->flash();
        } else {
            Alert::error(trans('backpack::base.error_saving'))->flash();
        }

        if($request->hasFile('image')){

            $user = User::find(Auth::id());

            $file = $request->file('image');
            $name = 'profile-' .$user->id.'-'. \Carbon\Carbon::now()->format('Y-m-d-H_i_s') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/files/users/photo/', $name);
            $user->image = 'files/users/photo/'.$name;
            $user->save();
        }

        return redirect()->back();
    }

    public function getChangePasswordForm()
    {
        $this->data['title'] = trans('backpack::base.my_account');
        $this->data['user'] = $this->guard()->user();
        return view('auth.account.change_password', $this->data);
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // check old password matches
            if (!Hash::check($this->input('old_password'), backpack_auth()->user()->password)) {
                $validator->errors()->add('old_password', trans('backpack::base.old_password_incorrect'));
            }
        });
    }


    public function postChangePasswordForm(Request $request)
    {
        $rules = [
            'old_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'confirm_password' => 'required|same:new_password|min:8'
        ];

        $validator = Validator::make($request->all(), $rules);

        if (!Hash::check($request->input('old_password'), auth()->user()->password)) {
            $validator->errors()->add('old_password', 'Old password incorrect');
            Alert::error('Failed to change password, Old password incorrect')->flash();
            return \Redirect::back()->withErrors(['Failed to change password, Old password incorrect']);
        }

        if ($validator->fails()) {
            Alert::error('Failed to change password, please use alphanumeric password')->flash();
            return \Redirect::back()->withErrors(['Failed to change password, please use alphanumeric password, Uppercase and lowercase character, min character 8']);
            return redirect()->back();
        }

        $user = $this->guard()->user();
        $user->password = Hash::make($request->new_password);
        $user->password_changed_at =Carbon::now()->toDateTimeString();


        if($request->new_password=='12345678'){
            Alert::error('You can\'t use 12345678 password, please set another password')->flash();
        }
        else if ($user->save()) {
            Alert::success(trans('backpack::base.account_updated'))->flash();
        } else {
            Alert::error(trans('backpack::base.error_saving'))->flash();
        }

        //return redirect()->back();
        //return redirect('admin')->with('status', 'Profile updated!');
        //return redirect('admin/dashboard')->with('status', 'Profile updated!');
        return redirect('admin/dashboard');
        //return Redirect::to('admin')->with('status', 'Successfully deleted');
    }

    protected function guard()
    {
        return backpack_auth();
    }
}
