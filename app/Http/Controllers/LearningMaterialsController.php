<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\LearningMaterial;

class LearningMaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return LearningMaterial::all();
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
        $learningMaterial = new LearningMaterial;
        $learningMaterial->title = $request->title;
        $learningMaterial->type = $request->type;
        $learningMaterial->subject_id = $request->subject_id;
        $destination = '';

        switch($request->type) {
            case 'url':
                $learningMaterial->url = $request->url;
                break;
            case 'file':
                $destination = join('/', array('learning-materials', $request->subject_id));
                $filename = $request->file('upload')->getClientOriginalName();
                $learningMaterial->url = $destination + $filename;
                if ($request->hasFile('upload')) {
                    $request->file('upload')->move($destination, $filename);
                }
                break;
        }

        ;
        return ['response' => $learningMaterial->save() ? 'success':'failed'];    
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
}
