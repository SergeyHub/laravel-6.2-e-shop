<filters-base></filters-base>


{{--
<form class="filters__bar js-filters__bar position-relative">
    --}}
{{-- Base for prices bar --}}{{--

    @include("pages.catalog._partials.filters.price")
    --}}
{{-- Base for availability filter --}}{{--

    @include("pages.catalog._partials.filters.availability")
    --}}
{{-- Render filter groups --}}{{--

    @foreach(filters()->tree()->groups as $group)
        @include("pages.catalog._partials.filters.group")
    @endforeach
    --}}
{{-- Render buttons --}}{{--

    @include("pages.catalog._partials.filters.buttons")
</form>
--}}
