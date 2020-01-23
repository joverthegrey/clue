@extends('layouts.app')

@section('content')
    <div class="container">
        @if ( $active->count() > 0 && $user->isAdmin() )
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 style="display: inline-block;">Actieve Hints</h3>
                            <button class="btn btn-primary float-right" id="show_active_clues_btn" ><i
                                    id="show_active_clues_icon" class="fas fa-eye"></i></button>
                        </div>
                        <div id="active_clues_body" class="card-body text-hide">
                            <ul>
                                @foreach( $active as $hint)
                                    <li>{{ $hint->type->name }}: {{ $hint->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="height: 20px;"></div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 style="display: inline-block;">Hint: {{ $type }}</h3>
                        <a class="btn btn-primary float-right" href="{{ route('home') }}"><i
                                class="fas fa-redo"></i></a>
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

@section('script')
    <script>
        $(document).ready(function() {
            $('#show_active_clues_btn').on('click', function () {
                // toggle icon and visibility
                clue_icon = $('#show_active_clues_icon');
                clue_card = $('#active_clues_body');
                if (clue_icon.hasClass('fa-eye')) {
                    clue_icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    clue_card.removeClass('text-hide');

                } else {
                    clue_icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    clue_card.addClass('text-hide');
                }
            });
        });
    </script>
@endsection
