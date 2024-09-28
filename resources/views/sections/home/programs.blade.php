<div class="container program-container" id="our-program">
    <div class="row">
        <div class="col-sm-12 section-head">
            <h4><span>Check Our </span> Programs</h4>
        </div>
        <div class="col-sm-12 program-card-container">
            {{-- {{dd($courses)}} --}}
            @foreach ( $courses as $course )
                <div class="card">
                    <img class="card-img-top" src="https://lirp.cdn-website.com/5d723f7de664428fab6c1e09200b20d1/dms3rep/multi/opt/709-376w.jpg" alt="Card image cap">
                    <div class="card-body">
                        <div class="course-card-header" style="width:100%;display:flex;justify-content:space-between; align-items:center">
                            <h2 class="course-title" style="font-size: 18px">{{$course->Name}}</h2>
                            <p class="course-price mb-2 text-muted">$.{{$course->Price}}</p>
                        </div>
                        <p class="card-description" style="font-weight: 500; text-align:left; margin-top:8px">{{$course->Description}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>