@extends('template.layout')
@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-light">About us</div>
                    <div class="card-body">
                            <p>We are a small company! Please enjoy our website.</p>
                        @guest
                            <p>You can start by creating an account <a href="{{ route('register') }}">here</a>.</p>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row justify-content-center">
            {{-- @foreach ($tshirtImage as $index => $tshirtImage)
               @if ($index < 9)
                   <div class="col-md-4 mt-4">
                       <div class="card">
                           <div class="card-header bg-dark text-light"> {{$tshirtImage->name}}</div>
                           <div class="card-body">
                               {{-- @auth --}}
                                {{-- <p>{{ Auth::user()->name }}</p> --}}
                                {{-- @else --}}
                               <!-- <img src="{{-- $tshirtImage->fullPhotoUrl--}}"
                                      width="380" height="380">
                                    <a href="{{-- route('register') --}}">here</a>.
                                </p>-->
                                {{-- @endauth
                            </div>
                        </div>
                    </div>
                @else
                    @break
                @endif
            @endforeach --}}
        </div>
    </div>

@endsection
