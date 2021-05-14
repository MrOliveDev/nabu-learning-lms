<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterfaceCfgModel;
use App\Models\User;
use App\Models\GroupModel;
use App\Models\PositionModel;
use App\Models\CompanyModel;

class StudentController extends Controller
{
    public function index()
    {
        $authors = User::where('type', '2')->get();
        $teachers = User::where('type', '3')->get();
        $students = User::where('type', '4')->get();
        $groups = GroupModel::all();
        $positions = PositionModel::all();
        $companies = CompanyModel::all();

        return view('student', compact(['authors', 'teachers', 'students', 'groups', 'positions', 'companies']));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function findGroup(Request $request)
    {
        print_r($request);exit;
        return response('findGroup', 200);
    }

    public function findSession(Request $request)
    {
        print_r($request);exit;
        return response('findSession', 200);
    }

    public function findCompany(Request $request)
    {
        print_r($request);exit;
        return response('findCompany', 200);
    }

    public function findUser(Request $request)
    {
        print_r($request);exit;
        return response('findStudent', 200);
    }

    public function findPosition(Request $request)
    {
        print_r($request);exit;
        return response('findStudent', 200);
    }

    public function getUserFromGroup(Request $request)
    {
        print_r($request);exit;
        return response('getStudentFromGroup', 200);
    }

    public function getGroupFromUser(Request $request)
    {
        print_r($request);exit;
        return response('getGroupFromStudent', 200);
    }
    public function getUserFromFunction(Request $request)
    {
        print_r($request);exit;
        return response('getUserFromFunction', 200);
    }
    public function getUserFromCompany(Request $request)
    {
        print_r($request);exit;
        return response('getUserFromCompany', 200);
    }
    public function getUser(Request $request)
    {
        print_r($request);exit;
        return response('getUser', 200);
    }
    public function editUser(Request $request)
    {
        print_r($request);exit;
        return response('editUser', 200);
    }
    public function addUser(Request $request)
    {
        print_r($request);exit;
        return response('addUser', 200);
    }
    public function deleteUser(Request $request)
    {
        print_r($request);exit;
        return response('deleteUser', 200);
    }
    public function editGroup(Request $request)
    {
        print_r($request);exit;
        return response('editGroup', 200);
    }
    public function addGroup(Request $request)
    {
        print_r($request);exit;
        return response('addGroup', 200);
    }
    public function deleteGroup(Request $request)
    {
        print_r($request);exit;
        return response('deleteGroup', 200);
    }
    public function editCompany(Request $request)
    {
        print_r($request);exit;
        return response('editCompany', 200);
    }
    public function addCompany(Request $request)
    {
        print_r($request);exit;
        return response('addCompany', 200);
    }
    public function deleteCompany(Request $request)
    {
        print_r($request);exit;
        return response('deleteCompany', 200);
    }
    public function editFunction(Request $request)
    {
        print_r($request);exit;
        return response('editFunction', 200);
    }
    public function addFunction(Request $request)
    {
        print_r($request);exit;
        return response('addFunction', 200);
    }
    public function deleteFunction(Request $request)
    {
        print_r($request);exit;
        return response('deleteFunction', 200);
    }

}
