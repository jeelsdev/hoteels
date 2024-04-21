@props(['submit'])

<div>
    <form wire:submit="{{ $submit }}">
        <div class="max-w-2xl">
            {{ $title }}
        </div>
        <div class="max-w-2xl">
            {{ $content }}
        </div>
        <div class="max-w-2xl mt-5 text-end">
            {{ $footer }}
        </div>
    </form>
</div>