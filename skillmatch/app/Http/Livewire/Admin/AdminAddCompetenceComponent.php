<?php

namespace App\Http\Livewire\Admin;

use App\Models\Competence;
use Livewire\Component;

class AdminAddCompetenceComponent extends Component
{
    public $nomcompetence;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            "nomcompetence" => "required"
        ]);
    }

    public function storecompetence()
    {
        $this->validate([
            "nomcompetence" => "required"
        ]);

        $competence = new Competence();
        $competence->nomcompetence = $this->nomcompetence;
        $competence->save();

        session()->flash('message', 'Attribute has been created successfully');
    }
    public function render()
    {
        return view('livewire.admin.admin-add-competence-component')->layout('layouts.default');
    }
}