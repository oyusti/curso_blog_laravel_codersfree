<?php

namespace App\Http\Livewire;

use App\Models\Answer as ModelsAnswer;

use Livewire\Component;

class Answer extends Component
{

    public $question;
    //public $answers;
    public $open=false;
    
    public $answer_create = [
        'open' => false,
        'body' => ''
    ];

    public $answer_edit=[
        'id' => null,
        'body' => ''
    ];

    public $answer_to_answer = [
        'id' => null,
        'body' => ''
    ];

    //propiedad computada que se encarga de obtener las respuestas para listarlos
    public function getAnswersProperty(){
        return $this->question
        ->answers()
        ->when(!$this->open, function($query){
            $query->take(0);
        })->get();
        
    }

   /*  public function getAnswers(){
        $this->answers = $this->question
        ->answers()
        ->take($this->cant_answers)
        ->get();
    } */


    public function store()
    {
        $this->validate([
            'answer_create.body' => 'required'
        ]);

        $this->question->answers()->create([
            'body' => $this->answer_create['body'],
            'user_id' => auth()->user()->id
        ]);

        $this->reset('answer_create');
    }


    public function edit($answerId)
    {
        $answer = ModelsAnswer::find($answerId);
        $this->answer_edit=[
            'id' => $answer->id,
            'body' => $answer->body
        ];
    }

    public function update(){
        $this->validate([
            'answer_edit.body' => 'required'
        ]);

        $answer = ModelsAnswer::find($this->answer_edit['id']);

        $answer->update([
            'body' => $this->answer_edit['body']
        ]);
        $this->reset('answer_edit');
    }

    public function destroy($questionId)
    {
        $answer = ModelsAnswer::find($questionId);
        $answer->delete();

    }

    public function answer_to_answer_store()
    {
        $this->validate([
            'answer_to_answer.body' => 'required'
        ]); 

        $this->question->answers()->create([
            'body' => $this->answer_to_answer['body'],
            'user_id' => auth()->user()->id
        ]);

        $this->reset('answer_to_answer');
        
    }

    public function cancel(){
        $this->reset('answer_edit');
    }

    public function show_answer(){
        $this->open = !$this->open;
    }

    public function render()
    {
        return view('livewire.answer');
    }
}
