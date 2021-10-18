<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ContactsController extends Controller
{
    public function create()
    {
        return view('create');
    }
    public function confirm(Request $request)
    {   
        $request-> validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'zip11'=> 'required|min:8',
            'addr11' => 'required',
            'opinion' => 'required|max:120',
        ]);
        
        $inputs = $request->all();
        $request->session()->put('lastname', 'firstname', 'gender', 'email', 'zip11', 'addr11', 'building_name', 'opinion');
        // dd($inputs);でデータ取得確認済み

        $request->session()->put('key', 'value');
        $request->session()->put('lastname', 'firstname', 'gender', 'email', 'zip11', 'addr11', 'building_name', 'opinion');

        Session::put('lastname', $inputs['lastname']);
        Session::put('firstname', $inputs['firstname']);
        Session::put('gender', $inputs['gender']);
        Session::put('email', $inputs['email']);
        Session::put('zip11', $inputs['zip11']);
        Session::put('addr11', $inputs['addr11']);
        Session::put('building_name', $inputs['building_name']);
        Session::put('opinion', $inputs['opinion']);

        return view('confirm',['inputs' => $inputs]);

    }
    public function process(Request $request)
    {
        $inputs = $request->except('action');
            
            Contact::insert([
            'fullname' => Session::get('lastname'). Session::get('firstname'),
            'gender' => Session::get('gender'),
            'email' => Session::get('email'),
            'postcode' => Session::get('zip11'),
            'address' => Session::get('addr11'),
            'building_name' => Session::get('building_name'),
            'opinion' => Session::get('opinion')
        ]);
        return redirect()->route('complete');

    }
    /**
     * 入力画面に戻る
     *
     * @return RedirectResponse
     */
    public function returnInput(): RedirectResponse
    {
        $inputs = [
            'lastname' => Session::pull('lastname'),
            'firstname' => Session::pull('firstname'),
            'gender' => Session::pull('gender'),
            'email' => Session::pull('email'),
            'zip11' => Session::pull('zip11'),
            'addr11' => Session::pull('addr11'),
            'building_name' => Session::pull('building_name'),
            'opinion' => Session::pull('opinion')
        ];
        
        return redirect()->route('create') -> withInput($inputs);
    }
    public function complete()
    {
        return view('complete');
    }
    public function index(Request $request)
    {
        $fullname = "";
        $email = "";
        $items = "";
        $created_at ="";
        $gender ="";
        return view('search', compact('items','fullname','email', 'created_at', 'gender'));
    }
    public function search(Request $request)
    {
        $query = Contact::query();

        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $created_at = Contact::get();
        $gender = $request->input('gender');

        if(!empty($fullname)) {
            $query->where('fullname', 'like', '%'.$fullname.'%');
        }
        // 日付検索（開始日）
        if (!empty($request['form']) && !empty($request['until'])) {
            $created_at = Contact::getDate($request['from'], $request['until']);
            // $query->where('created_at', '%Y-%m-%d','LIKE', '%'.$created_at.'%');
            // $query->where('created_at', '=', $created_at)->get();
            // created_at', '%Y-%m-%d','LIKE', '%'.$date.'%'
        }
        // 日付検索（終了日）
        // if (!empty($request->end_date)) {
        //     $query->where('created_at', '<=', $request->end_date)->get();
        // }
        if (!empty($email)) {
            $query->where('email', 'like', '%' . $email . '%');
        }

        if(!empty($gender)) {
            $query->where('gender', $gender);
        }

        if($request->has('fullname')) {
            $query->where('fullname', 'like', '%' . $request->get('fullname') . '%');
        }

        foreach ($request->only(['fullname', 'email','created_at','gender']) as $key => $value) {
            $query->where($key, 'like', '%' . $value . '%');
        }

        $items = $query->get()->paginate(10);
        // $items = $query->get()->paginate(10);
        $items = Contact::paginate(10);

        return view('search', compact('items','fullname','created_at','email','gender'));
        // ->with(['fullname' => $fullname, 'email' => $email]);
    }
    public function delete(Request $request)
    {
        $item = Contact::find($request->id)->delete();
        return redirect('/search');
    }
}
