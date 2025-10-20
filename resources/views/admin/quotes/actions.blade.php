<div class="flex item-center space-x-4">

    @can('read-quotes')
    <x-wire-button>
        <i class="fa-solid fa-envelope text-xl"></i>
    </x-wire-button>

    <x-wire-button href="{{ route('admin.quotes.pdf', $quote) }}">
        <i class="fa-solid fa-file-pdf text-xl"></i>
    </x-wire-button>
    @endcan


</div>