<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subject;
use App\SubjectStudent;
use App\User;

class SubjectController extends Controller
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
        return Subject::where('user_id', $request->user_id)->get();
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
        $subject = new Subject;
        $subject->user_id = $request->user_id;
        $subject->subject_code = $request->subject_code;
        $subject->description = $request->description;

        return ['response' => $subject->save() ? 'success':'failed'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Subject::find($id);
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
        $subject = Subject::find($id);
        $subject->subject_code = $request->subject_code;
        $subject->description = $request->description;
        
        return ['response' => $subject->save() ? 'success':'failed'];
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

    public function getStudents(Request $request) {
        $students = Subject::find($request->subject_id)->students;
        $data = array();
        foreach ($students as $student) {
            array_push($data, User::find($student->user_id));
        }

        return $data;
    }

    public function addStudents(Request $request) {
        foreach(json_decode($request->users, true) as $i => $v) {
            $subjectStudent = SubjectStudent::firstOrCreate(['subject_id' => $request->subject_id, 'user_id' => $v]);
        }
    }
}
