<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Faq as FaqModel;

#[Title('FAQ')]
class Faq extends Component
{
    public $faqs;
    public $search = '';

    public function mount()
    {
        $this->loadFaqs();
    }

    public function updatedSearch()
    {
        $this->loadFaqs();
    }

    public function loadFaqs()
    {
        $query = FaqModel::query();

        if (!empty($this->search)) {
            $query->where('pertanyaan', 'like', '%' . $this->search . '%')
                  ->orWhere('jawaban', 'like', '%' . $this->search . '%');
        }

        $this->faqs = $query->get();
    }

    public function render()
    {
        return view('livewire.faq');
    }
}
