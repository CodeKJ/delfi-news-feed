@extends('layouts.app')

@section('content')
    <style>
        .change-avatar > span {
            color: #3490dc;
            text-decoration: none;
            background-color: transparent;
        }
        .change-avatar > span:hover {
            color: #1d68a7;
            text-decoration: underline;
            cursor: pointer;
        }
        .change-avatar {
            border: 1px solid transparent;
            border-radius: 5px;
            padding:5px;
        }
        .change-avatar:hover {border: 1px solid #1d68a7; cursor: pointer;}
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profila Uzstādījumi</div>

                    <div class="card-body">

                        @if(request()->session()->exists('success'))
                            <div class="alert alert-success">
                                {{ request()->session()->get('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="m-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('profile-update') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}


                            <div class="form-group text-center">
                                <label class="change-avatar">
                                    <span>Mainīt avataru</span><br>
                                    <img class="img-fluid" width="64" src="{{ auth()->user()->avatar }}" alt="avatar">
                                    <input name="avatar" type="file" class="form-control-file" style="display: none;" onchange="this.form.submit()" >
                                </label><br>
                                <small class="text-muted">(rekomendētais attēla izmērs vismaz 64x64px)</small>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Vārds</label>
                                        <input name="name" type="text" class="form-control" placeholder="Tavs vārds" value="{{ auth()->user()->name }}">
                                    </div>
                                    <div class="col-md-6">

                                        <label>Epasts</label>
                                        <input name="email" type="email" class="form-control" placeholder="Tavs epasts" value="{{ auth()->user()->email }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="row">

                                    <div class="col-md-6">

                                        <label>Noklusētā ziņu kategorija</label>
                                        <select name="default_channel" class="form-control">
                                            @foreach(config('services.delfi.channels') as $channel => $name)
                                                <option value="{{ $channel }}" {{ ($channel == auth()->user()->default_channel ? 'selected' : '') }}>{{ $name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-6">

                                        <label>Ziņu skaits vienā lapā</label>
                                        <select name="default_paginate" class="form-control">
                                            @for($i=5;$i<=20;$i=$i+5)
                                                <option value="{{ $i }}" {{ ($i == auth()->user()->default_paginate ? 'selected' : '') }}>{{ $i }}</option>
                                            @endfor
                                        </select>

                                    </div>

                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">Saglabāt</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
