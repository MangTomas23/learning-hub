<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Attempt;

class AttemptController extends Controller
{
    
    public function store(Request $request)
    {
        $attempt = new Attempt;

        $attempt->quiz_id = $request->quiz_id;
        $attempt->user_id = $request->student_id;

        return ['response' => $attempt->save() ? 'success':'failed'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        return ["taken"=>Attempt::where(['quiz_id'=>$id, 
                'user_id'=>$request->user_id])->count()];
    }
}
