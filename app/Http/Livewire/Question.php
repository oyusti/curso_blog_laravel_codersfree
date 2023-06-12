<?php

namespace App\Http\Livewire;

use App\Models\Question as ModelsQuestion;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Question extends Component
{

    //Propiedades
    public $model;
    public $message;
    public $cant=10;
    public $question_edit=[
        'id' => null,
        'body' => ''
    ];

    //propiedad computada que se encarga de obtener los comentarios para listarlos
    public function getQuestionsProperty(){
        return $this->model
        ->questions()
        ->orderBy('created_at','desc')
        ->take($this->cant)
        ->get();
    }
    
    //Metodo que se encarga de crear un nuevo comentario
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
    }

    //Metodo que se encarga de editar un comentario
    public function edit($id)
    {
        $question = ModelsQuestion::find($id);
        $this->question_edit=[
            'id' => $question->id,
            'body' => $question->body
        ];
    }

    //Metodo que se encarga de actualizar un comentario
    public function update(){
        $this->validate([
            'question_edit.body' => 'required'
        ]);

        $question = ModelsQuestion::find($this->question_edit['id']);
        $question->update([
            'body' => $this->question_edit['body']
        ]);
        $this->reset('question_edit');
    }

    //Metodo que se encarga de eliminar un comentario
    public function destroy($id)
    {
        $question = ModelsQuestion::find($id);
        $question->delete();

        $this->reset('question_edit');
    }

    //Metodo que se encarga de cancelar la edicion de un comentario
    public function cancel(){
        $this->reset('question_edit');
    }

    //Metodo que se encarga de mostrar mas comentarios
    public function show_more_questions(){
        $this->cant = $this->cant + 10;
    }

    //Metodo que se encarga de renderizar la vista
    public function render()
    {
        return view('livewire.question');
    }
}
