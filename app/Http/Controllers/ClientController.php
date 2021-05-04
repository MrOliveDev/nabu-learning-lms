<?php

namespace App\Http\Controllers;

use App\Models\InterfaceCfgModel;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientsListArray = User::get_clientsInfo();
        $clientsList = array();
        foreach ($clientsListArray as $key => $client) {
            $test = $client->toArray();
            $clientsList[$client->id] = array();

            foreach ($test as $key1 => $value) {
                $clientsList[$client->id][$key1] = $value;
            }
            $clientsList[$client->id]['interface_color'] = json_decode($clientsList[$client->id]["interface_color"]);
            // print_r($clientsList[$client->id]['interface_color']);
            // exit;
        }

        // print_r($clientsList['6667']['interface_color']);
        // $a = json_decode($clientsList['6667']['interface_color']);
        // print_r($clientsList);
        // exit;

        return view('clients.layout', compact('clientsList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // return view('student.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        print_r("Create!");
        exit;
        // print_r($request);
        // exit;
        $request->validate([
            'login' => 'required',
            'company' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'address' => 'required',
            'email' => 'required',
            'languagePlatform' => 'required',
            'pack' => 'required'
        ]);

        $client = new User([
            'login' => $request->get('login'),
            'company' => $request->get('company'),
            'firstName' => $request->get('firstName'),
            'lastName' => $request->get('lastName'),
            'address' => $request->get('address'),
            'email' => $request->get('email'),
            'languagePlatform' => $request->get('languagePlatform'),
            'pack' => $request->get('pack')
        ]);

        $client->save();
        return redirect('/clients.layout')->with('success', 'Client has been added');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        //
        // return view('student.view',compact('student'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return view('student.edit',compact('student'));

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        var_dump("sjf");
        exit;
        //
        // var_dump($request . $id);

        $request->validate([
            'login' => 'required',
            'company' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'address' => 'required',
            'email' => 'required',
            'languagePlatform' => 'required',
            'pack' => 'required'
        ]);


        $client = User::find($id);
        print_r($client);exit;
        $client->login = $request->get('login');
        $client->company = $request->get('company');
        $client->first_name = $request->get('firstname');
        $client->last_name = $request->get('lastname');
        $client->contact_info = $request->get('address');
        $client->email = $request->get('email');
        $client->lang = $request->get('languagePlatform');
        $client->pack = $request->get('pack');

        $client->update();

        return redirect('/clients.layout')->with('success', 'Client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = User::find($id);
        $client->delete();
        return redirect('/clients.layout')->with('success', 'Client deleted successfully');
    }
}
