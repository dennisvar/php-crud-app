<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\client_event;

class clientNotificationController extends Controller
{
    public function addClientNotification(Request $req){
        $client_event = new client_event();
        $client_event->client_id = $req->input('client_id');
        $client_event->notification_id = $req->input('notification_id');
        $client_event->start_date = $req->input('start_date');
        $client_event->frequency_day = $req->input('frequency');
        $client_event->status = true;
        
        $client_event->save();

        return redirect()->route('view-client-notifications');

    }
    public function allData(){
        $client_events = client_event::all();

        //$client->all();
        return view('clientEventList',['events' =>  $client_events]);
    }
    
    public function viewClientNotification($id){
        $client_event = new client_event();
        return view('updateClientEvent', ['event' => $client_event->find($id)]);
    }
    public function updateClientNotification($id,Request $req){
        $client_event = client_event::find($id);
        $client_event->client_id = $req->input('client_id');
        $client_event->notification_id = $req->input('notification_id');
        $client_event->start_date = $req->input('start_date');
        $client_event->frequency_day = $req->input('frequency');
        $client_event->status = ($req->has('status'))? 1:0;
        
        $client_event->save();

        return redirect()->route('view-client-notifications');
    }
}
