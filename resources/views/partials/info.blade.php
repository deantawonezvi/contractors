@if(session('info'))
    <div class="alert alert-info"><p>{{session('info')}}</p></div>
@endif

@if(session('warning'))
    <div class="alert alert-warning"><p>{{session('warning')}}</p></div>
@endif

@if(session('success'))
    <div class="alert alert-success"><p>{{session('success')}}</p></div>
@endif