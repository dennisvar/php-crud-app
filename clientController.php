<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\clientRequest;
use App\Models\Client;

class clientController extends Controller
{
    //
    public function addClient(clientRequest $req){
        $client = new Client();
        $client->company_name = $req->input('company');
        $client->business_number = $req->input('businessNumber');
        $client->first_name = $req->input('fname');
        $client->last_name = $req->input('lname');
        $client->phone = $req->input('phone');
        $client->cell_number = $req->input('cellNumber');
        $client->carrier = $req->input('carrier');
        $client->hst = $req->input('hst');
        $client->website = $req->input('webSite');
        $client->status = true;
        
        $client->save();

        return redirect()->route('view-clients');

    }
    public function allData(){
        $clients = Client::all();

        //$client->all();
        return view('clientList',['clients' =>  $clients]);
    }
    
    public function viewClient($id){
        $client = new Client();
        return view('updateClient', ['client' => $client->find($id)]);
    }
    public function updateClient($id,clientRequest $req){
        $client = Client::find($id);
        $client->company_name = $req->input('company');
        $client->business_number = $req->input('businessNumber');
        $client->first_name = $req->input('fname');
        $client->last_name = $req->input('lname');
        $client->phone = $req->input('phone');
        $client->cell_number = $req->input('cellNumber');
        $client->carrier = $req->input('carrier');
        $client->hst = $req->input('hst');
        $client->website = $req->input('webSite');
        $client->status = ($req->has('status'))? 1:0;
        
        $client->save();

        return redirect()->route('view-clients');
    }
}
