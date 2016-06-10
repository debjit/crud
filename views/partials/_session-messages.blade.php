
@if (Session::has('message.info'))
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>{{ trans('crud::messages.info.title') }}</strong>
        {{ Session::get('message.info') }}
    </div>
@endif

@if (Session::has('message.success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>{{ trans('crud::messages.success.title') }}</strong>
        {{ Session::get('message.success') }}
    </div>
@endif

@if (Session::has('message.error'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>{{ trans('crud::messages.error.title') }}</strong>
        {{ Session::get('message.error') }}

        @if (count($errors) > 0)
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endif

@if (Session::has('message.warning'))
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>{{ trans('crud::messages.warning.title') }}</strong>
        {{ Session::get('message.warning') }}
    </div>
@endif
