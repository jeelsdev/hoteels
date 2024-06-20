<?php

namespace App\Livewire\Admin\Movement\Expense;

use App\Livewire\Admin\Movement\Expenses;
use App\Models\Expense;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
{
    public Expense $expense;
    public $create = true;
    public $description;
    public $amount;

    #[On("editExpense")]
    public function edit($id)
    {
        $this->expense = Expense::findOrFail($id);
        $this->description = $this->expense->description;
        $this->amount = $this->expense->amount;
        $this->create = false;
    }

    public function update()
    {
        $this->validate([
            'description' => 'required',
            'amount' => 'required',
        ]);
        $this->expense->update([
            'description' => $this->description,
            'amount' => $this->amount,
        ]);
        $this->reset(['description', 'amount']);
        $this->create = true;
        session()->flash('flash.message', 'Egreso actualizado correctamente.');
        $this->dispatch('refreshExpenses');
    }
    public function save()
    {
        $this->validate([
            'description' => 'required',
            'amount' => 'required',
        ]);
        Expense::create([
            'description' => $this->description,
            'amount' => $this->amount,
        ]);
        $this->reset(['description', 'amount']);
        session()->flash('flash.message', 'Egreso agregado correctamente.');
        $this->dispatch('refreshExpenses');
    }
    public function render()
    {
        return view('livewire.admin.movement.expense.create');
    }
}
