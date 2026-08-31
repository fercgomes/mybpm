<?php

namespace App\Http\Livewire;

use App\Models\BModel;
use App\Services\PostHogService;
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

    public function save(string $xml, PostHogService $posthog)
    {
        $this->model->content = $xml;
        $this->model->save();
        $posthog->capture('model_saved', [
            'model_id' => $this->model->id,
        ]);
        error_log("Saving bpm");

        session()->flash('message', 'Post successfully updated.');
    }

    public function render()
    {
        return view('livewire.bpm-editor', ['model' => $this->model]);
    }
}