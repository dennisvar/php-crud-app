<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class notificationController extends Controller
{
    function addNotification(Request $req){
        $req -> validate([
            'name' => 'required',
            'type' => 'required',
            //add validation
        ]);
        $notification = new Notification();
        $notification->name = $req->input('name');
        $notification->type = $req->input('type');
        $notification->status = true;
        if($notification->save()){
            return redirect()->route('view-notifications');
        } else {
            return back()->with('Something went wrong');
        }
    }
    function updateNotification($id,Request $req){
        $req -> validate([
            'name' => 'required',
            'type' => 'required',
            //Add validation
        ]);
        $notification = Notification::find($id);
        $notification->name = $req->input('name');
        $notification->type = $req->input('type');
        
        $notification->status = ($req->has('status'))? 1:0;
        if($notification->save()){
            return redirect()->route('view-notifications');
        } else {
            return back()->with('Something went wrong');
        }
    }
    public function allData(){
        $notifications = Notification::all();

        //$client->all();
        return view('notificationList',['notifications' =>  $notifications]);
    }
    
    public function viewNotification($id){
        $notification = new Notification();
        return view('updateNotification', ['notification' => $notification->find($id)]);
    }
}
