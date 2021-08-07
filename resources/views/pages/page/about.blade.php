@extends('layouts.app')
@section('content')

<div class="about-page">
    <div class="container">
        @include('shared.breadcrumb')
        <h1 class="main-title acticle-title text-center">{!! rv($title) !!}</h1>
        <div class="article-content">
            <div class="mb-4 mx-auto col-md-8 field-text">
                {!! rv($page->body) !!}
            </div>
        </div>
    </div>
    @include('shared.members')
    <div class="container">
        @if ($page->data['details'] ?? null)
        <div class="product-description about-rec">
            <div class="col-xl-8 col-lg-10 mx-auto">
                <h2 class="main-title text-center">Реквизиты</h2>

                <div class="table__wrapper">
                    <table class="table">
                        <tbody>
                            @foreach (explode("\n",$page->data['details']) as $row)
                            <tr>
                                <td class="caption">{!! rv(explode('|',$row)[0]) !!}</td>
                                <td>{!! rv(explode('|',$row)[1] ?? '') !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
