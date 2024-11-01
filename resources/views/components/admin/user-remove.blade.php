<button
    type="button"
    wire:click="removeUser('{{ $key }}')">
    <img
        src="{{ asset('images/svg/tash.svg') }}" alt="Delete"
        width="15" />
</button>
