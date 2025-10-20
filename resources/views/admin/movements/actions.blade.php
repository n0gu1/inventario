<div class="flex item-center space-x-4">

    @can('read-movements')
    <x-wire-button>
        <i class="fa-solid fa-envelope text-xl"></i>
    </x-wire-button>

    <x-wire-button href="{{ route('admin.movements.pdf', $movement) }}">
        <i class="fa-solid fa-file-pdf text-xl"></i>
    </x-wire-button>
    @endcan

</div>