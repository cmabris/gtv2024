<?php

namespace App\Http\Livewire\Admin\Email;

use App\Models\EmailForAdmin as Email;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class EmailManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $email;
    public $listeners = ['delete'];

    public $search;
    public $searchColumn = 'id';

    public $sortField = 'id';
    public $sortDirection = 'asc';

    protected $queryString = ['search'];

    public $createForm = [
        'open' => false,
        'body' => '',
    ];

    public $editForm = [
        'body' => '',
    ];

    protected $rules = [
        'createForm.body' => 'required|max:2000',
    ];

    protected $validationAttributes = [
        'createForm.body' => 'cuerpo del mensaje',
        'editForm.body' => 'cuerpo del mensaje',
    ];

    public $editModal = [
        'open' => false,
        'id' => null,
    ];

    public function show($id)
    {
        $this->email = Email::findOrFail($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->email = null;
    }

    public function edit(Email $email)
    {
        $this->editModal['id'] = $email->id;
        $this->editForm['body'] = $email->body;
        $this->editModal['open'] = true;
    }

    public function save()
    {
        $this->validate();

        $email = Email::create([
            'body' => $this->createForm['body'],
        ]);

        $this->reset('createForm');

        $this->emit('emailCreated');
    }

    public function update(Email $email)
    {
        $this->validate([
            'editForm.body' => 'required|max:2000',
        ]);

        $email->update([
            'body' => $this->editForm['body'],
        ]);

        Log::info('Email with ID ' . $email->id . ' was updated');

        $this->editModal['open'] = false;
        $this->reset(['editForm']);

        $this->emit('emailUpdated');
    }

    public function delete(Email $email)
    {
        $email->delete();

        Log::info('Email with ID ' . $email->id . ' was deleted');
    }

    public function sort($field)
    {
        if ($this->sortField === $field && $this->sortDirection !== 'desc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'sortField', 'sortDirection']);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Profesor')) {
            $emails = Email::where($this->searchColumn, 'like', '%' . $this->search . '%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10);

            return view('livewire.admin.email.email-manager', compact('emails'));
        }
    }
}