<nav>
    <a href="{{ url('/') }}"><img src="{{ asset('img/ikon.png') }}" alt=""></a>
    <a href="tel:+62318856988"><i class="fas fa-phone"></i> (031) 8856988</a>
    &middot;
    <a href="mailto:smkislamkrembung@gmail.com"><i class="fas fa-envelope"></i> smkislamkrembung</a>
    &middot;
    <a href="https://maps.app.goo.gl/qWxkqNMzXbjwmyM7A" target="_blank"><i class="fas fa-map-marker-alt"></i> SMK Islam Krembung</a>
    <span>
        {{ now()->setTimezone('Asia/Jakarta')->format('l, d F Y H:i:s A') }}
    </span>
</nav>


