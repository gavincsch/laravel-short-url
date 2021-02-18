@extends('shorturl::layout')

@section('shorturl.content')
    <div class="col-8 offset-2">
        <h1 class="text-center mb-5">
            Laravel Short Url
        </h1>

        {!! $url->expired_message  !!}

    </div>
@endsection