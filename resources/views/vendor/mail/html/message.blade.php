@component('mail::layout')
    {{-- Header --}}
    @slot('header')
            @component('mail::header')
                {{ 'BAIUST - Student Portal Password' }}
            @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ 'BAIUST ICT WING' }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
