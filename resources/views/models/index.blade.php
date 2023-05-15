<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Models') }}
        </h2>

        <x-primary-button-link href="{{ route('models.create') }}">New Model</x-primary-button-link>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <ul class="space-y-4">
                @foreach($models as $model)
                    <li class="bg-white shadow overflow-hidden sm:rounded-lg my-8">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ $model['name'] }}
                            </h3>

                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                BPMN Model
                            </p>

                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Last update at: {{ $model->updated_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>

                        <div class="border-t border-gray-200">
                            <div class="-mt-px flex justify-between items-center px-4 py-3 sm:px-6">
                                <div class="flex items-center">
                                </div>

                                <div class="ml-5 flex-shrink-0">
                                    <span class="inline-flex rounded-md shadow-sm">
                                        <a href="{{ route('models.edit', ['id' => $model['id']]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-700 transition ease-in-out duration-150">
                                            Go to Modeler
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</x-app-layout>


