<script src="{{asset('vendor/blackfyrestudio/crud/scripts/crud.js')}}"></script>

@foreach (Config::get('crud.assets.javascript') as $javascript)
    <script src="{{ asset($javascript) }}"></script>
@endforeach

</body>

</html>
