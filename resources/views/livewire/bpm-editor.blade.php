<header class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center">
            <div class="text-3xl font-bold text-gray-800 mr-4">
                <div class="text-gray-700 mr-4">{{ $model->name }}</div>
            </div>
            <div class="text-sm text-gray-600">
                @if ($model['updated_at'])
                Last updated {{ $updatedAt }}
                @else
                Not yet updated
                @endif
            </div>
            <div class="ml-auto">
                <div wire:loading>saving...</div>

                <x-danger-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'delete-model')"
                >{{ __('Delete Model') }}</x-danger-button>

                <x-secondary-button onClick="exportXml()">Export</x-secondary-button>

                <x-primary-button onClick="save()">
                    Save
                </x-primary-button>

            </div>
        </div>
    </div>
</header>

{{-- BPM Modeler --}}
<div id="modeler-container" >
    <div id="canvas-container">
        <div id="bpmn-editor" />
    </div>
    <div id="properties-container"  />
</div>

<x-modal name="delete-model"  focusable>
    <form method="post" action="{{ route('models.destroy', ['id' => $model->id]) }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Are you sure you want to delete this model?') }}
        

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3">
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>

@push('scripts') 
    <script type="module" id="modeler">
        import { saveXml, exportXml, createModeler } from "{{ Vite::asset('resources/js/modeler.js') }}" 

        const model = @js($model);
        const modeler = createModeler(model.content, "bpmn-editor");

        window.save = function() {
            const fn = (xml) => {
                console.log("saving 2", xml)
                @this.save(xml);
            }

            saveXml(modeler, fn);
        }

        window.exportXml = function () {
            exportXml(modeler, model.name);
        }

    </script>
@endpush


@push('styles')
<link rel="stylesheet" href="https://unpkg.com/bpmn-js@13.0.5/dist/assets/bpmn-js.css">
<link rel="stylesheet" href="https://unpkg.com/bpmn-js@13.0.5/dist/assets/diagram-js.css">
<link rel="stylesheet" href="https://unpkg.com/bpmn-js@13.0.5/dist/assets/bpmn-font/css/bpmn.css">
<link rel="stylesheet" href="https://unpkg.com/bpmn-js-properties-panel/dist/assets/properties-panel.css">
@vite('resources/css/modeler.css')
@endpush
