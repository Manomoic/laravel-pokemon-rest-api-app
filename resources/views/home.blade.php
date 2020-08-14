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
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div id="display_api_results"></div>
            </div>
        </div>
    </div>

    {{-- <select id="index_loop" class="form-control"></select> --}}

</div>

<script>
    // Add more numbers to view poke-results
    const URI = `https://pokeapi.co/api/v2/pokemon?limit=5`;
    window.fetch(URI, {
        headers: {
            'Accept-Language' : 'en-US',
            'Connection' : 'Keep-Alive',
            'Content-type' : 'application/json',
        }
    })
        .then(response => {
            if ( response.response >= 400 ) {
                return response.json().then( (errorResponse) => {
                    const error = new Error('Something Went Wrong During Record Saving.');
                    error.data = errorResponse;
                    throw error;
                });
            }
            
            if ( response.ok ) {
                return response.json();
            }
        })
        .then((responseJSON) => {
            const apiResponseCounter = responseJSON.results.length;
            let index_loop = '';
            let display_api_results = '';
            

            for (let i in responseJSON.results) {                
                const URL_ID = `${responseJSON.results[i].url}`;
                window.fetch(URL_ID)
                    .then(res => {
                        if ( res.response >= 400 ) {
                            return res.json().then( (errorResponse) => {
                                const error = new Error('Something Went Wrong During Record Saving.');
                                error.data = errorResponse;
                                throw error;
                            });
                        }
                        
                        if ( res.ok ) {
                            return res.json();
                        }
                    })
                    .then((pokeInfo) => {
                        
                        display_api_results += `
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id=\"heading-${i}\">
                                    <h2 class="mb-0 lead">
                                        <button class="btn btn-link btn-block text-left text-uppercase" type="button" data-toggle="collapse"
                                            data-target=\"#collapse-${i}\" aria-expanded="true" aria-controls=\"collapse-${i}\">
                                            ${responseJSON.results[i].name}
                                        </button>
                                    </h2>
                                </div>
                        
                                <div id=\"collapse-${i}\" class="collapse" aria-labelledby=\"heading-${i}\" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="row g-0 border overflow-hidden flex-md-row mb-4 h-md-250 position-relative">
                                            <div class="col p-4 d-flex flex-column position-static">
                                                <h4 class="mb-0">Abilities</h4>
                                                <div class="mb-1 text-muted">${pokeInfo.moves['0'].move.name}</div>
                                            </div>
                                            <div class="col-auto d-none d-lg-block">
                                                <img src=\"https://pokeres.bastionbot.org/images/pokemon/${i}.png\" alt=\"${responseJSON.results[i].name}'s Image\" style="margin: 0 auto;width: 100%;height: 30vh;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        document.getElementById('display_api_results').innerHTML = display_api_results;
                    })
                    .catch(error => console.log(error));

                // display_api_results += `
                // <ul class="list-group">
                //     <li class="list-group-item d-flex justify-content-between align-items-center lead">
                //         <a href=\"${responseJSON.results[i].url}\">${responseJSON.results[i].name}</a>
                //         <span class="badge bg-primary rounded-pill text-white">${i}</span>
                //     </li>
                // </ul>`;

                // document.getElementById('index_loop').innerHTML = index_loop;
                

                // console.log(fetch(`https://pokeapi.co/api/v2/pokemon/${i}`))
            }
        })
        .catch((error) => console.log(error));
</script>
@endsection