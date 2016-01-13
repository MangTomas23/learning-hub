<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Hash;
use App\TemporaryPassword;
use League\Csv\Reader;

class UserController extends Controller
{

   public function __construct()
   {
       $this->middleware('jwt.auth');
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->type;
        if($request->has('search')) {
            $users = User::search($request->search)->where('type', $request->type)->get();
        }else{
            $users = User::where('type', $request->type)->get(); 
        }
        foreach ($users as $user) {
            $user->temporaryPassword;
        }
        return $users;
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
        $user = new User;
        $user->usn = $request->usn;
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->type = $request->type;
        $user->lastname = $request->lastname;
        $user->password = bcrypt($request->password);

        $r = array();
        $r['response'] = $user->save() ? 'success':'failed';

        $temp = new TemporaryPassword;
        $temp->user_id = $user->id;
        $temp->password = $request->password;
        $temp->save();
        return $r;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
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
        $user = User::find($id);

        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->usn = $request->usn;

        $r = array();
        $r['response'] = $user->save() ? 'success':'failed';

        return $r;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return ['response' => User::destroy($id) ? 'success':'failed'];
    }

    public function changePassword(Request $request) {
        $user = User::find($request->id);

        if (!Hash::check($request->password, $user->password)) {
            return ['response' => 'invalid password'];
        }

        $user->password = Hash::make($request->new_password);

        return [ 'response' => $user->save() ? 'success':'failed' ];
    }

    public function import(Request $request) {
        $request->file('upload')->move(public_path(), 'tempform.csv');
        $reader = Reader::createFromPath(public_path() . '\tempform.csv');
        $reader->setDelimiter(';');
        $results = $reader->setOffset(1)->fetch();

        foreach ($results as $row) {
            $user = new User;
            $user->usn = $row[0];
            $user->firstname = $row[1];
            $user->middlename = $row[2];
            $user->lastname = $row[3];
            $user->type = 'student';
            $user->password = bcrypt($row[4]);
            $user->save();

            $temp = new TemporaryPassword;
            $temp->user_id = $user->id;
            $temp->password = $row[4];
            $temp->save();
        }

        return ['response' => 'success'];
    }
}
