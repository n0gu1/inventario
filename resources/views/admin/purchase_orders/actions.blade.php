<div class="flex item-center space-x-4">

    @can('update-purchase-orders')
    <x-wire-button>
        <i class="fa-solid fa-envelope text-xl"></i>
    </x-wire-button>

    <x-wire-button href="{{ route('admin.purchase-orders.pdf', $purchaseOrder) }}">
        <i class="fa-solid fa-file-pdf text-xl"></i>
    </x-wire-button>
    @endcan

</div>