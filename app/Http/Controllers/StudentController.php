<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SubjectStudent;
use App\Subject;
use App\Quiz;
use App\User;
use App\Question;
use App\Choice;
use App\Answer;
use App\Result;
use App\Attempt;

class StudentController extends Controller
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

    public function getSubject($id) {
        $subject = Subject::find($id);
        $subject->teacher;
        $subject->learningMaterials;
        $subject->quizzes;
        return $subject;
    }

    public function getSubjects(Request $request) {
        $subjectStudents = SubjectStudent::where('user_id',$request->user_id)->get();
        foreach ($subjectStudents as $subjectStudent) {

            $subjectStudent->subject;

            $t = $subjectStudent->subject->teacher;
            $firstname = $t->firstname;
            $middlename = $t->middlename;
            $lastname = $t->lastname;

            $fullname = $firstname . ' ' . $middlename . ' ' . $lastname;

            $subjectStudent['teacher'] = $fullname;
        }

        return $subjectStudents;
    }

    public function getQuizzes(Request $request) {
        $subjects = SubjectStudent::select('subject_id')
            ->where('user_id',$request->user_id)->get();
        $quizzes = Quiz::whereIn('subject_id', $subjects)->get();
        foreach ($quizzes as $quiz) {
            $quiz->subject;
        }

        return $quizzes;
    }

    public function getQuiz($id) {
        $questions = Question::where('quiz_id', $id)->get();

        foreach ($questions as $question) {
            $question->answers;
            $question->choices;
        }

        return $questions->shuffle();
    }

    public function submitQuiz($id, Request $request) {
        $quiz = Quiz::find($id);
        $data = json_decode($request->data);
        $correctAnswer = 0;
        $points = 0;
        $total = $quiz->questions->sum('points');

        //checking starts here....
        foreach ($data as  $d) {
            $question = Question::find($d->question);

            switch ($question->type) {
                case 'true_or_false':
                    if($question->answers[0]->text == $d->answer) {
                        $correctAnswer++;
                        $points += $question->points;
                    }
                    break;
                case 'multiple_choice':
                    if($question->answers[0]->choice_id == $d->answer) {
                        $correctAnswer++;
                        $points += $question->points;
                    }
                    break;
                
            }
        }

        $r = [
            'correct_answer' => $correctAnswer, 
            'no_of_items' => sizeof($data),
            'points' => $points,
            'total' => $total,
            'mistakes' => count($quiz->questions) - $correctAnswer
            ];

        $result = new Result;

        $result->quiz_id = $request->quiz_id;
        $result->user_id = $request->user_id;
        $result->result_data = $request->data;
        $result->score = $correctAnswer;
        $result->save();

        return $r;
    }

    public function getNotifications($id) {
        $availableQuiz = 0;

        $ss = SubjectStudent::where('user_id', $id)->get();
        foreach ($ss as $s) {
            $subject = $s->subject;
            $quizzes = $subject->quizzes;
            $availableQuiz += $quizzes->count();

            foreach ($quizzes as $q) {
                $attempts = Attempt::where(['user_id' => $id, 'quiz_id'=>$q->id])->groupBy('quiz_id')->count();
                $availableQuiz -= $attempts;
            }
        }

        // return ['response' => ''] ;
        return ['response' => $availableQuiz < 1 ? '':$availableQuiz] ;
    }
}
