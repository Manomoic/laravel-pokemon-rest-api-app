@extends('layouts.app')

@section('content')
    <section id="pokecharacter" class="container">
        <div class="card bg-dark text-white mb-3 mx-auto" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="https://pokeres.bastionbot.org/images/pokemon/{{$singleRestPokemon['id']}}.png"
                        alt="{{$singleRestPokemon['name']}} cover image" class="rounded w-100 d-block" />
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title h6 lead text-capitalize">{{$singleRestPokemon['name']}}</h5>
                        <p class="card-text">
                            This pokemon is of <strong>TYPE</strong>
                            @foreach ($singleRestPokemon['types'] as $key => $item)
                                {{ $item['type']['name'] }}@if (!$loop->last), @endif
                            @endforeach
                        </p>
                        <ol class="list-group list-group-flush">
                            <h6 class="h6">Attack moves</h6>
                            @foreach ($singleRestPokemon['moves'] as $key => $item)
                                @if ($key <= 5)
                                    <li>{{ $item['move']['name'] }}</li>
                                @endif
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection