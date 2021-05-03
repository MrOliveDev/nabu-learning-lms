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
        $clients=User::get_clients();
        return view('clients.layout', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'txtFirstName'=>'required',
            'txtLastName'=> 'required',
            'txtAddress' => 'required'
        ]);

        $student = new Student([
            'first_name' => $request->get('txtFirstName'),
            'last_name'=> $request->get('txtLastName'),
            'address'=> $request->get('txtAddress')
        ]);

        $student->save();
        return redirect('/student')->with('success', 'Student has been added');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return view('student.view',compact('student'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('student.edit',compact('student'));

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //

        $request->validate([
            'txtFirstName'=>'required',
            'txtLastName'=> 'required',
            'txtAddress' => 'required'
        ]);


        $student = Student::find($id);
        $student->first_name = $request->get('txtFirstName');
        $student->last_name = $request->get('txtLastName');
        $student->address = $request->get('txtAddress');

        $student->update();

        return redirect('/student')->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $student->delete();
        return redirect('/student')->with('success', 'Student deleted successfully');
    }
}
