<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class employeeController extends Controller
{
    //
    function login(){
        
        return view('login');
    }
    function check(Request $request){
        $request -> validate([
            'login' => 'required|email',
            'password' => 'required',
        ]);
        
        $userInfo = Employee::where('email', $request->login)->first();
        if($userInfo && Hash::check($request->password, $userInfo->password)){
            if($userInfo->status == 1){
                $request->session()->put('LoggedUser', $userInfo->id);
                return redirect()->route('view-clients');
            } else {
                return back()->with('fail','Access Denied: The status is inactive');
            }
            
            //return back()->with('fail','We do not recognize your email address');
        }else{
            return back()->with('fail','Incorrect Login or Password');  
        }
    }
    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect()->route('login');
        }
    }
    function addEmployee(Request $req){
        $req -> validate([
            
            //add validation
        ]);
        $employee = new Employee();
        $employee->first_name = $req->input('fname');
        $employee->last_name = $req->input('lname');
        $employee->email = $req->input('email');
        $employee->cell_number = $req->input('cellNumber');
        $employee->position = $req->input('position');
        $employee->password = Hash::make($req->input('password'));
        $employee->picture = $req->input('picture');
        $employee->status = true;
        if($employee->save()){
            return redirect()->route('view-employees');
        } else {
            return back()->with('Something went wrong');
        }
    }
    function updateEmployee($id,Request $req){
        $request -> validate([
            'login' => 'required|email',
            'password' => 'required',
            //Add validation
        ]);
        $employee = Employee::find($id);
        $employee->first_name = $req->input('fname');
        $employee->last_name = $req->input('lname');
        $employee->email = $req->input('email');
        $employee->cell_number = $req->input('cellNumber');
        $employee->position = $req->input('position');
        $employee->password = Hash::make($req->input('password'));
        $employee->picture = $req->input('picture');
        $employee->status = ($req->has('status'))? 1:0;
        if($employee->save()){
            return redirect()->route('view-employees');
        } else {
            return back()->with('Something went wrong');
        }
    }
    public function allData(){
        $employees = Employee::all();

        //$client->all();
        return view('employeeList',['employees' =>  $employees]);
    }
    
    public function viewEmployee($id){
        $employee = new Employee();
        return view('updateEmployee', ['employee' => $employee->find($id)]);
    }
}
