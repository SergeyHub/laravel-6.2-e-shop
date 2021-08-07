@if (\App\Models\Member::whereStatus(1)->orderBy('order')->count())

<div class="members__wrapper text-center">
    <div class="container">
        <h2 class="main-title members__title">{!! rv('Сотрудники магазина') !!}</h2>
        <div class="members row justify-content-center">
            @foreach (\App\Models\Member::whereStatus(1)->orderBy('order')->get() as $member)
            <div class="member col-xl-3 col-lg-4 col-md-6">

                <div class="member__image">
                    <img src="{{ asset($member->image) }}" alt="{{ $member->name }}">
                </div>
                <h3 class="member__name">{{ rv($member->name) }}</h3>
                <div class="member__position">{{ rv($member->position) }}</div>
                <a class="member__email" href="mailto:{{ $member->email }}">
                    <span class="member__email__icon" >@svg('images/svg/mail-contacts.svg')</span>
                    {{ $member->email }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
