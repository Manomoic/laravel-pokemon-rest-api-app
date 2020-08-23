@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-white rounded shadow-sm">
        <div class="lh-1">
            <h6 class="mb-0 text-dark lh-1 h4">RESTful Pokémon</h6>
            <small class="text-dark">
                Fetching the original Pokemon using the Poke API.
            </small>
        </div>
    </div>

    <div class="row g-3">
        @foreach ($requestPokenApi as $key => $pokemCollection)
            <div class="col-md-4 py-2 px-2">
                <div class="card">
                    <div class="d-flex align-items-center justify-content-between lead w-10 text-dark mx-3 my-3">
                        <div class="h6 text-capitalize">
                            <a href="{{ route('show', $key + 1) }}">{{ $pokemCollection['name'] }}</a>
                        </div>

                        <span class="badge bg-darken-3 text-darken">{{ $key }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection