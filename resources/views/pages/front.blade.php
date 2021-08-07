@extends('layouts.app')
@section('content')
    @foreach($blocks as $block)
        @include('shared.blocks.'.$block['key'],['data'=>$block['values']])
    @endforeach
@endsection
