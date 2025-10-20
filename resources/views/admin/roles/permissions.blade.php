<div class="flex flex-wrap gap-1">
    @forelse ($permissions as $permission)
        <x-wire-badge>
            {{ __('permissions.' . $permission->name) ?? $permission->name }}
        </x-wire-badge>
    @empty
        <x-wire-badge secundary>
            {{ __('Sin permisos asignados') }}
        </x-wire-badge>
    @endforelse
</div>
