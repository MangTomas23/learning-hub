<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Quiz;
use App\Question;
use App\Answer;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $quiz = new Quiz;
        $quiz->user_id = $request->user_id;
        $quiz->subject_id = $request->subject_id;
        $quiz->title = $request->title;
        $quiz->notes = $request->notes;
        $quiz->duration = $request->duration;
        $quiz->status = $request->status;
        $quiz->due_date = $request->due_date;
        $quiz->save();

        $questions = $request->questions;

        foreach (json_decode($questions) as $i=>$q) {
            $question = new Question;
            $question->text = $q->question;
            $question->quiz_id = $quiz->id;
            $question->save();

            $answer = new Answer;
            $answer->text = $q->answer;
            $answer->question_id = $question->id;
            $answer->save();
        }

        return $questions;

        // return ['response' => $quiz->save() ? 'success':'failed'];
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