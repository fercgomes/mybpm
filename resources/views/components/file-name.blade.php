<!-- resources/views/components/file-name.blade.php -->

@props(['name'])

<div class="flex items-center">
    <div class="text-gray-700 mr-4">{{ $name }}</div>
    <button x-data="{ editing: false }"
            x-init="() => {
                $watch('editing', value => {
                    if (value) {
                        $nextTick(() => $refs.input.focus());
                    }
                });
            }"
            x-on:click="editing = true"
            x-show="!editing"
            class="text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.707,3.293c0.391,0.391,0.391,1.023,0,1.414L7.114,14.707c-0.188,0.188-0.442,0.293-0.707,0.293
            s-0.52-0.105-0.707-0.293l-3-3C2.105,11.52,2,11.266,2,11s0.105-0.52,0.293-0.707l9-9C10.684,1.105,10.938,1,11.207,1
            s0.523,0.105,0.707,0.293l3,3C17.098,2.27,17.098,2.902,16.707,3.293z"/>
            <path fill-rule="evenodd" d="M14,5.414V7H6V5.414L9.707,2H10h0.293L14,5.414z"/>
            <path fill-rule="evenodd" d="M7,13.586V12h8v1.586L12.293,17H12h-0.293L7,13.586z"/>
            <path fill-rule="evenodd" d="M4,16c0,0.553,0.447,1,1,1h10c0.553,0,1-0.447,1-1s-0.447-1-1-1H5C4.447,15,4,15.447,4,16z"/>
        </svg>
    </button>
    <form x-show="editing" x-on:submit.prevent="editing = false" class="flex items-center">
        <input type="text"
               x-ref="input"
               x-bind:value="$wire.model"
               x-on:input="$wire.set('name', $event.target.value)"
               class="form-input w-full text-gray-700 border-b-2 border-gray-400 focus:border-blue-600 focus:outline-none">
        <button type="submit"
                class="ml-4 px-2 py-1 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
            Save
        </button>
    </form>
</div>
