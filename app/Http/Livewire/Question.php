<?php

namespace App\Http\Livewire;

use App\Models\Question as ModelsQuestion;
use Livewire\Component;

class Question extends Component
{

    public $model;
    public $message;
    public $questions;
    public $question_edit=[
        'id' => null,
        'body' => ''
    ];

    public function mount(){
        $this->getQuestions();
    }

    public function getQuestions(){
        $this->questions =  $this->model
                ->questions()
                ->orderBy('created_at','desc')
                ->get();
    }

    public function store()
    {

        $this->validate([
            'message' => 'required'
        ]);

        $this->model->questions()->create([
            'body' => $this->message,
            'user_id' => auth()->user()->id
        ]);
        $this->message = '';
        $this->getQuestions();
    }

    public function edit($id)
    {
        $question = ModelsQuestion::find($id);
        $this->question_edit=[
            'id' => $question->id,
            'body' => $question->body
        ];
    }

    public function update(){
        $this->validate([
            'question_edit.body' => 'required'
        ]);

        $question = ModelsQuestion::find($this->question_edit['id']);
        $question->update([
            'body' => $this->question_edit['body']
        ]);
        $this->getQuestions();
        $this->reset('question_edit');
    }

    public function destroy($id)
    {
        $question = $this->model->questions()->find($id);
        $question->delete();
    }

    public function cancel(){
        $this->reset('question_edit');
    }

    public function render()
    {
        return view('livewire.question');
    }
}
