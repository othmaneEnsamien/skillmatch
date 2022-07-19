<?php

namespace App\Http\Livewire\Admin;

use App\Models\Competence;
use Livewire\Component;

class AdminEditCompetenceComponent extends Component
{
    public $competence_id;
    public $nomcompetence;

    public function mount($competence_id)
    {
        $competence = Competence::find($competence_id);
        $this->nomcompetence = $competence->nomcompetence;
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'nomcompetence' => 'required',
        ]);
    }
    public function updatecompetence()
    {
        $this->validate([
            'nomcompetence' => 'required',

        ]);
        $competence = Competence::find($this->competence_id);
        $competence->nomcompetence = $this->nomcompetence;
        $competence->save();
        session()->flash('message', 'competence updated successfuly');
    }

    public function render()
    {
        $competences = Competence::all();
        return view('livewire.admin.admin-edit-competence-component', compact('competences'))->layout('layouts.default');
    }
}