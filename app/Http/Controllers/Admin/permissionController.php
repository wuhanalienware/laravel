<?php

namespace App\Http\Controllers\Admin;

use App\Model\permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class permissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per = permission::get();
        return view('admin.permission.list',compact('per'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permission.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');
        $res = permission::create($input);
        $data = $this->result($res);
        return $data;
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
        $per = permission::find($id);
        return view('admin.permission.edit', compact('per'));
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
        $per = permission::find($id);
        $pername = $request->input('per_name');
        $perurl = $request->input('per_url');
        $per->per_name = $pername;
        $per->per_url = $perurl;
        $res = $per->save();
        $data = $this->result($res);
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = permission::find($id);
        $res = $user->delete();
        $data = $this->result($res);
        return $data;
    }
}
