@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 style="display: inline-block;">Hint: {{ $type }}</h3>
                    <a class="btn btn-primary float-right" href="{{ route('home') }}"><i class="fas fa-redo"></i></a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>
                        {{ $clue }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
