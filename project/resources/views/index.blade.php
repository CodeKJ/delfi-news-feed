@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card mb-3">

                <div class="card-body pr-2 pl-2 pb-0 pt-0">

                    <h1 class="text-center"><img class="img-fluid" src="{{ $image }}"></h1>

                    <form method="get" action="">

                        <div class="row">

                            <div class="col-12 col-md-12 col-lg-4 text-right mb-2">
                                <select name="channel" onchange="this.form.submit()" class="form-control form-control-sm" name="perPage" style="height:calc(1.5em + 1rem)" autofocus>
                                    @foreach(config('services.delfi.channels') as $channel => $name)
                                        <option value="{{ $channel }}" {{ ($selected_channel == $channel ? 'selected' : '') }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-5 col-md-5 col-lg-4 text-center">
                                {!! $paginator !!}
                            </div>

                            <div class="col-3 col-md-3 col-lg-2">
                                <select onchange="this.form.submit()" class="form-control form-control-sm" name="paginate" style="height:calc(1.5em + 1rem)">
                                    @for($i=5;$i<=20;$i=$i+5)
                                        <option value="{{ $i }}" {{ ($selected_paginate == $i ? 'selected' : '') }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-4 col-md-4 col-lg-2">
                                <a href="{{ $link }}" target="_blank" class="btn btn-primary">Lasīt visu</a>
                            </div>

                        </div>

                    </form>
                </div>

            </div>

            @if($articles->isNotEmpty())

                @foreach($articles as $article)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 mb-2">
                                    <img class="card-img" src="{{ $article->image }}" alt="{!! $article->title !!}">
                                </div>
                                <div class="col-12 col-md-8">
                                    <h5 class="card-title"><a href="{{ $article->link }}" target="_blank">{!! $article->title !!}</a></h5>
                                    <p class="card-text">{!! $article->description !!}</p>

                                </div>

                            </div>

                        </div>

                        <div class="card-footer text-muted p-2 pr-3 pl-3">

                            <div class="row">
                                <div class="col-5 col-md-5 my-auto">
                                    {{ $article->pubDate }}
                                </div>

                                <div class="col-7 col-md-7 text-right">
                                    <a class="mr-2" href="{{ $article->link }}&com=1&reg=1&no=0&s=1" target="_blank">{{ $article->comments }} komentāri</a>
                                    <a href="{{ $article->link }}" target="_blank" class="btn btn-primary btn-sm">Lasīt vairāk</a>
                                </div>
                            </div>

                        </div>

                    </div>
                @endforeach

                <div class="d-flex justify-content-center">
                    {!! $paginator !!}
                </div>

            @else
                <div class="alert alert-info mt-3">
                    Šajā kategorijā nav jaunu ziņu
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
