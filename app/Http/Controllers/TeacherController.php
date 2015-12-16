<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Subject;
use App\SubjectStudent;
use App\Quiz;
use App\Question;
use App\Answer;
use App\Choice;
use App\Result;
use DB;

class TeacherController extends Controller
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

    public function getStudents(Request $request) {
        $subjects = User::find($request->user_id)->subjects;
        $subjectIds = array();
        foreach ($subjects as $subject) {
            array_push($subjectIds, $subject->id);
        }

        $students = SubjectStudent::select('user_id')->whereIn('subject_id', $subjectIds)->groupBy('user_id')->get();



        return User::whereIn('id', $students)->get();
    }

    public function getSubjects(Request $request) {
        $id = $request->id;
        $subjects = Subject::where('user_id', $id)->get();
        foreach($subjects as $subject) {
            $subject['students_count'] = SubjectStudent::where('subject_id',$subject->id)->count();
        }

        return $subjects;
    }

    public function getSubjectQuizzes(Request $request) {
        return Quiz::where('subject_id', $request->subject_id)->get();
    }

    public function getQuiz($id)  {
        $quiz = Quiz::find($id);
        $quiz['due_date'] = date("Y-m-d\TH:i:s", strtotime($quiz->due_date));

        $questions = $quiz->questions;
        foreach ($questions as $question) {
            $question->answers;
            $question->choices;
        }

        $quiz['questions'] = $questions;
        return $quiz;
    }

    public function updateQuestion(Request $request) {
        $type = $request->type;
        $question = Question::find($request->question_id);
        $question->text = $request->question;
        $question->save();

        $answer = Answer::find($question->answers->first()->id);

        switch ($type) {
            case 'true_or_false':
                $answer->text = $request->answer;
                break;
            case 'multiple_choice':
                $answer->text = $request->answer;
                $choices = $question->choices;

                $letters = ['A','B','C','D'];
                foreach ($choices as $i => $choice) {
                    $choice->text = json_decode($request->choices)[$i];
                    $choice->save();

                    if($request->answer == $letters[$i]) {
                        $answer->choice_id = $choice->id;
                    }
                }
                break;
        }
        
        $answer->save();
    }

    public function deleteQuestion(Request $request) {
        Question::destroy($request->question_id);
    }

    public function getResults($id) {

        $quiz = Quiz::find($id);
        $quiz->no_of_items = $quiz->questions->count();
        $quiz['results'] = DB::table('results')->select(DB::raw('id, max(score) as score, quiz_id, user_id'))
                            ->groupBy('user_id')->orderBy('score')->get();
        foreach ($quiz['results'] as $result) {

            $result->student = User::find($result->user_id);
        }

        return $quiz;
    }
}
