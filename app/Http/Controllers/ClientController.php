<?php

namespace App\Http\Controllers;

use App\Models\ConfigModel;
use App\Models\InterfaceCfgModel;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\JsonDecoder;

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
            // print_r(json_decode($clientsList[$client->id]["pptimport"])->PPTImport); exit;
            $clientsList[$client->id]['email'] = json_decode($clientsList[$client->id]["contact_info"])->email;
            $clientsList[$client->id]['contact_info'] = json_decode($clientsList[$client->id]["contact_info"])->address;
            $clientsList[$client->id]['pptimport'] = json_decode($clientsList[$client->id]["config"])->PPTImport;
            $clientsList[$client->id]['config'] = "";
            // print_r($clientsList[$client->id]['interface_color']);
            // exit;
        }

        // print_r($clientsList['6665']['interface_color']);
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
        $request->validate([
            'login' => 'required',
            'password' => 'required',
            'company' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'contact_info' => 'required',
            'email' => 'required',
            'lang' => 'required',
            'pack' => 'required'
        ]);

        $interfaceCfg = InterfaceCfgModel::create([
            'interface_color' => $request->input('interface_color'),
            'interface_icon' => $request->input('base64_img_data'),
            'admin_id' => '1'
        ]);

        $client = User::create([
            'login' => $request->input('login'),
            'password' => $request->input('password'),
            'company' => $request->input('company'),
            'first_name' => $request->input('firstname'),
            'last_name' => $request->input('lastname'),
            'contact_info' => $request->input('contact_info'),
            'email' => $request->input('email'),
            'lang' => $request->input('lang'),
            'pack' => $request->input('pack'),
            'id_config' => $interfaceCfg->id,
            'type' => 1
        ]);
        var_dump($client->id);
        exit;
        User::create_admin_table($client->id);

        return redirect('/clients')->with('success', 'Client has been added');
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

        $request->validate([
            'login' => 'required',
            'company' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'contact_info' => 'required',
            'email' => 'required',
            'lang' => 'required',
            'pack' => 'required'
        ]);

        $contact_info = array(
            'address' => $request->input('contact_info'),
            'email' => $request->input('email')
        );
        // print_r($request->input('login')."\n".'login');
        // print_r($request->input('company')."\n".'company');
        // print_r($request->input('password')."\n".'password');
        // print_r($request->input('firstname')."\n".'firstname');
        // print_r($request->input('lastname')."\n".'lastname');
        // print_r($request->input('address')."\n".'address');
        // print_r($request->input('email')."\n".'email');
        // print_r($request->input('lang')."\n".'lang');
        // print_r($request->input('pack')."\n".'pack');
        //  exit;

        $client = User::find($id);

        $interfaceCfg = InterfaceCfgModel::find($client->id_config);
        $interfaceCfg->interface_color = $request->input('interface_color');
        if ($request->input('base64_img_data') != null) {
            $interfaceCfg->interface_icon = $request->input('base64_img_data');
        }

        $interfaceCfg->update();

        $config = ConfigModel::find($client->id_config);
        $tempconfig = json_decode($config->config);
        $tempconfig->PPTImport1= $request->input('pptimport');
        $config->config=json_encode($tempconfig);

        $config->update();

        $client->login = $request->input('login');
        $client->company = $request->input('company');
        $client->password = $request->input('password');
        $client->first_name = $request->input('firstname');
        $client->last_name = $request->input('lastname');
        $client->status = $request->input('status');
        $client->contact_info = json_encode($contact_info);
        $client->lang = $request->input('lang');
        $client->pack = $request->input('pack');

        $client->update();

        return redirect('/clients')->with('success', 'Client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // print_r("dflsjldf"); exit();
        // print_r($client);exit;
        // var_dump($client->id);
        // exit;
        $client = User::find($id);
        InterfaceCfgModel::where('id', $client->id_config)->delete();
        ConfigModel::where('id', $client->id_config)->delete();
        User::drop_admin_table($id);
        $client->delete();
        return response('Deleted Successfully', 200);
    }
}
