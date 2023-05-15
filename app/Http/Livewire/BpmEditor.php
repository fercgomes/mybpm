<?php

namespace App\Http\Livewire;

use App\Models\BModel;
use Carbon\Carbon;
use Livewire\Component;

class BpmEditor extends Component
{
    public BModel $model;
    public string $updatedAt;

    public function mount(BModel $model)
    {
        $this->model = $model;
        $this->updatedAt = Carbon::parse($model->updated_at)->diffForHumans();
    }

    public function save(string $xml)
    {
        $this->model->content = $xml;
        $this->model->save();
        error_log("Saving bpm");

        session()->flash('message', 'Post successfully updated.');
    }

    public function render()
    {
        return view('livewire.bpm-editor', ['model' => $this->model]);
    }
}