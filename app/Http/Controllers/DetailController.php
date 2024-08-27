<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DetailController extends Controller
{
    public function details_form()
    {
        $user = Auth::user();
        $list = Department::get();
        if (auth()->user()->hasRole('KB')) {
            $dep = Department::where('staff_id', $user->staff_id)->first();
            return view('auth/detail_form', ['user' => $user, 'list' => $list, 'dep' => $dep]);
        }

        return view('auth/detail_form', ['user' => $user, 'list' => $list, 'dep' => null]);
    }

    // detail form process
    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'department' => 'required',
            'phone' => 'required',
            'img' => 'required|image|max:10240 ',
        ]);
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'department' => $request->department,
            'phone' => $request->phone,
        ];

        //image restore process
        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $filename = date('Y-m-d') . $img->getClientOriginalName();
            $path = '/borrower_photo/' . $filename;
            Storage::disk('public')->put($path, file_get_contents($img));
            $data['img'] = $filename;
        } else {
            //default image
            $filename = 'default.png';
            $data['img'] = $filename;
        }
        $result = User_info::whereId($request->id)->update($data);
        Auth::guard('web')->logout();
        if ($result) {
            return redirect()->intended(route('login'))->with('success', 'Berjaya mengemas kini data. Sila log masuk semula');

        } else {
            return redirect()->intended(route('login'))->with('error', 'Ralat berlaku');
        }

    }

    public function department()
    {
        return view('auth/department');
    }

    public function department_p(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'leader' => 'required',
            'staff_id' => 'required',
        ]);
        $data = [
            'name' => $request->name,
            'leader' => $request->leader,
            'staff_id' => $request->staff_id,
        ];
        $result = Department::create($data);
        Auth::guard('web')->logout();
        if ($result)
            return redirect()->intended(route('department'))->with('success', 'Successful add new department');
        else
            return redirect()->intended(route('department'))->with('error', 'Failed to add new department');
    }

    public function back()
    {
        Auth::guard('web')->logout();
        return redirect(route('login'));
    }
}
