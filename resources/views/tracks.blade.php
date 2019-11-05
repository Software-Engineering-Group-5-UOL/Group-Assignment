@extends('/layout')

@section('content')
<div class="track-wrapper">
    <h1 class="title text-center">New Songs</h1>
    <nav aria-label="Songs per track">
      <ul class="pagination justify-content-center">
        <li class="page-item {{($nrSongs == 5) ? 'disabled active' : '' }}">
            <a class="page-link" href="/track/5" {{($nrSongs == 5) ? 'tabindex="-1"' : '' }}>5</a>
        </li>
        <li class="page-item {{($nrSongs == 10) ? 'disabled active' : '' }}">
            <a class="page-link" href="/track/10" {{($nrSongs == 10) ? 'tabindex="-1"' : '' }}>10</a>
        </li>
        <li class="page-item {{($nrSongs == 15) ? 'disabled active' : '' }}">
            <a class="page-link" href="/track/15" {{($nrSongs == 15) ? 'tabindex="-1"' : '' }}>15</a>
        </li>
      </ul>
    </nav>
    @for($i = 0 ; $i < $nrSongs ; $i++)
    <div class="ice-panel d-flex mb-3">
        <div class="song-img-wrapper d-flex" title="Song Name or Album Here">
            <img class="song-img" src="{{ URL::asset('images/blank.png') }}" alt="">
        </div>
        <div class="song-info-wrapper d-flex">
            <h2><b>Song's Name</b></h2>
            <h5>Album's Name</h5>
            <h4>Name of the Artist</h4>
        </div>
    </div>
    @endfor
</div>
@endsection