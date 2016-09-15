<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersEditRequest;
use App\Http\Requests\UsersRequest;
use App\Photo;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        //
//
//        $users = User::all();
//
//
//        return view('admin.users.index', compact('users'));
//
//
//    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //


        $users = User::all();



        return view('admin.users.index', compact('users'));



    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


        $roles = Role::lists('name','id')->all();


        return view('admin.users.create', compact('roles'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        //

        //User::create($request->all());

        if(trim($request->password) == '') {

            $input = $request->except('password');

        } else {

            $input = $request->all();

            $input['password'] = bcrypt($request->password);

        }



        //$input = $request->all();

        if($file = $request->file('photo_id')) {

            //return "photo exists";

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;


        }



        User::create($input);


        Session::flash('message', 'The User has been Created');


        return redirect('/admin/users');


        //return $request->all();



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
        return view('admin.users.show');
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


        $user = User::findOrFail($id);

        $roles = Role::lists('name', 'id')->all();




        return view('admin.users.edit', compact('user', 'roles'));








    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        //

        $user = User::findOrFail($id);

        //$input = $request->all();


        if(trim($request->password) == '') {

            $input = $request->except('password');

        } else {

            $input = $request->all();

            $input['password'] = bcrypt($request->password);

        }



        if($file = $request->file('photo_id')) {


            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);

            $input['photo_id'] = $photo->id;


        }


        $user->update($input);

        Session::flash('message', 'The User has been Updated');

        return redirect('/admin/users');

//        return $request->all();


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

        //return "DESTROY";

//        User::findOrFail($id)->delete();

        $user = User::findOrFail($id);

//        unlink(public_path() . "/images/" . $user->photo->file);
        unlink(public_path() . $user->photo->file);

        $user->delete();


        //Session::flash('deleted_user', 'The User has been Deleted');
        Session::flash('message', 'The User has been Deleted');





        return redirect('/admin/users/');


    }
}
