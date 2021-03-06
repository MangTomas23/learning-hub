<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Quiz;
use App\Question;
use App\Answer;
use App\Choice;
use App\Attempt;

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

        // return strtotime($request->due_date);
        $quiz = new Quiz;
        $quiz->user_id = $request->user_id;
        $quiz->subject_id = $request->subject_id;
        $quiz->title = $request->title;
        $quiz->notes = $request->notes;
        $quiz->duration = $request->duration;
        $quiz->status = $request->status;
        $quiz->due_date = $request->due_date;
        $quiz->attempts = $request->attempts;
        $quiz->save();

        $questions = $request->questions;

        foreach (json_decode($questions) as $i=>$q) {
            $question = new Question;
            $question->text = $q->question;
            $question->quiz_id = $quiz->id;
            $question->type = $q->type;
            $question->points = $q->points;
            $question->save();
            $answer = new Answer;

            switch ($q->type) {
                case 'true_or_false':
                    $answer->text = $q->answer;
                    break;
                case 'multiple_choice':
                    $letters = ['A','B','C','D'];

                    foreach ($q->choices as $i => $c) {
                        $choice = new Choice;
                        $choice->text = $c;
                        $choice->question_id = $question->id;
                        $choice->save();

                        if($q->answer == $letters[$i]) {
                            $answer->text = $q->answer;
                            $answer->choice_id = $choice->id;
                        }
                    }

                    break;
                
                default:
                    # code...
                    break;
            }
                
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
        if(!$quiz =  Quiz::find($id)) {
            return [];
        }  
        
        $quiz['no_of_items'] = Question::where('quiz_id', $quiz->id)->count();

        return $quiz;
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
        $quiz = Quiz::find($id);
        $quiz->title = $request->title;
        $quiz->notes = $request->notes;
        $quiz->duration = $request->duration;
        $quiz->status = $request->status;
        $quiz->due_date = $request->due_date;
        $quiz->attempts = $request->attempts;
        
        return ['response' => $quiz->save() ? 'success':'failed'];        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return ['response' => Quiz::destroy($id) ? 'success':'failed'];
    }
}
