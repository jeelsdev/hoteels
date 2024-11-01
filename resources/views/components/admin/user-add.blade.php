@props(['value' => ''])

<button
    class="z-30 flex items-center px-0 py-1 mb-0 transition-all ease-in-out border-0 rounded-lg cursor-pointer text-slate-700 bg-inherit"
    data-tab-target=""
    active role="tab"
    aria-selected="true"
    >
    <img
        src="{{ asset('images/svg/add-user.svg') }}"
        alt="add user"
        width="25" />
    <span>{{ $value }}</span>
</button>
