<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public $module_name;

    #[Url(as: 'q')]
    public $search = '';

    public $paginate = 15;

    public function delete($id)
    {
        LivewireAlert::title(__('Are you sure?'))
            ->warning()
            ->withConfirmButton(__('Yes, Delete'))
            ->withCancelButton(__('Cancel'))
            ->onConfirm('deleteConfirmed', ['idToDelete' => $id])
            ->show();
    }

    public function deleteConfirmed($data)
    {
        $user = User::find($data['idToDelete']);
        $user->delete();
        LivewireAlert::title(trans_choice(
            '{0} ¡El :resource fue eliminado!|{1} ¡La :resource fue eliminada!',
            1,
            ['resource' => __(ucwords($this->module_name))]
        ))
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function placeholder()
    {
        return view('table-loader');
    }

    public function render()
    {
        $query = User::query();

        $query->when($this->search, function ($q) {
            $q->where('id', 'like', "%{$this->search}%")
                ->orWhere('name', 'like', "%{$this->search}%");
        });

        $data = $query->latest()->paginate($this->paginate);

        return view('livewire.admin.user.user-table', [
            'data' => $data,
        ]);
    }
}
