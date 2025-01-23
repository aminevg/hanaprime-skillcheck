@props(['hideOnMobile' => true])

<div {{ $attributes->merge(['class' => 'flex gap-2']) }}>
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
        viewBox="0 0 24 24">
        <g fill="none" stroke="black" stroke-linecap="round"
            stroke-linejoin="round" stroke-width="2">
            <path d="M18 9.52a4.04 4.04 0 1 1 2-3.47" />
            <circle cx="17" cy="7.8" r="2" />
            <path d="m14 2.5l-2 1.3a6 6 0 1 0 6 10.4l2-1.2a4 4 0 0 0-4-6.95" />
            <path d="M9.77 12C4 15 2 22 2 22" />
            <path d="M13 20s-5 3-9.2-2c0 0 5.2-3 9.2 2" />
        </g>
    </svg>
    <span @class([
        'font-hachimarupop text-2xl font-semibold',
        'hidden md:inline-block' => $hideOnMobile,
    ])>Hana日記</span>
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
        viewBox="0 0 24 24" @class(['-scale-x-100', 'hidden md:block' => $hideOnMobile])>
        <g fill="none" stroke="black" stroke-linecap="round"
            stroke-linejoin="round" stroke-width="2">
            <path d="M18 9.52a4.04 4.04 0 1 1 2-3.47" />
            <circle cx="17" cy="7.8" r="2" />
            <path d="m14 2.5l-2 1.3a6 6 0 1 0 6 10.4l2-1.2a4 4 0 0 0-4-6.95" />
            <path d="M9.77 12C4 15 2 22 2 22" />
            <path d="M13 20s-5 3-9.2-2c0 0 5.2-3 9.2 2" />
        </g>
    </svg>
</div>
