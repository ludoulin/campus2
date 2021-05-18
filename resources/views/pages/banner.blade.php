<div class="container my-3">
    <div class="row">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            @foreach ($activities as $index => $activity)
              <li data-target="#carouselExampleControls" data-slide-to="{{$index}}" class="@if($index===0) active @endif"></li>
            @endforeach
          </ol>
          <div class="carousel-inner">
            @foreach ($activities as $index => $activity)
            <div class="carousel-item @if($index===0) active @endif">
              <a href="{{route("activity.show",$activity->id)}}">
                <img class="d-block w-100" src="{{asset($activity->avatar)}}" alt="{{$activity->name}}">
              </a>
            </div>
            @endforeach
          </div>
          <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
          </a>
        </div>
    </div>
</div>