<?php

namespace App\Http\Livewire\Admin;

use App\Models\Projet;
use Livewire\Component;

class AdminProjetComponent extends Component
{
    public  $projet, $niveauprojet, $projet_edit_id, $projet_delete_id;


    public $searchTerm;



    public function updated($fields)
    {
        $this->validateOnly($fields, [

            'projet' => 'required',
            'niveauprojet' => 'required',

        ]);
    }



    public function storeProjetData()
    {

        $this->validate([
            'projet' => 'required',
            'niveauprojet' => 'required',
        ]);



        $projets = new Projet();
        $projets->projet = $this->projet;
        $projets->niveauprojet = $this->niveauprojet;
        $projets->save();


        session()->flash('message', 'New project has been added successfully');
        $this->projet = '';
        $this->niveauprojet = '';



        $this->dispatchBrowserEvent('close-modal');
    }


    public function resetInputs()
    {

        $this->projet = '';
        $this->niveauprojet = '';
        $this->projet_edit_id = '';
    }


    public function close()
    {
        $this->resetInputs();
    }


    public function editProjets($id)
    {
        $projets = Projet::where('id', $id)->first();


        $this->projet_edit_id = $projets->id;
        $this->projet = $projets->projet;
        $this->niveauprojet = $projets->niveauprojet;



        $this->dispatchBrowserEvent('show-edit-projet-modal');
    }

    public function editProjetData()
    {
        //on form submit validation
        $this->validate([

            'projet' => 'required',
            'niveauprojet' => 'required',
        ]);


        $projets = Projet::where('id', $this->projet_edit_id)->first();

        $projets->projet = $this->projet;
        $projets->niveauprojet = $this->niveauprojet;



        $projets->save();


        session()->flash('message', 'Projet has been updated successfully');



        $this->dispatchBrowserEvent('close-modal');
    }



    public function deleteConfirmation($id)
    {
        $this->projet_delete_id = $id;


        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }


    public function deleteProjetData()
    {
        $projets = Projet::where('id', $this->projet_delete_id)->first();
        $projets->delete();


        session()->flash('message', 'Projet has been deleted successfully');


        $this->dispatchBrowserEvent('close-modal');


        $this->projet_delete_id = '';
    }


    public function cancel()
    {
        $this->projet_delete_id = '';
    }


    public function render()
    {
        $projets = Projet::where('projet', 'like', '%' . $this->searchTerm . '%')->orWhere('niveauprojet', 'like', '%' . $this->searchTerm . '%')->orWhere('id', 'like', '%' . $this->searchTerm . '%')->get();
        return view('livewire.admin.admin-projet-component', compact('projets'))->layout('layouts.default');
    }
}