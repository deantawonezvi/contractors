@if(session('info'))
    <div class="alert alert-info"><p>{{session('info')}}</p></div>
@endif
@if(session('warning'))
    <div class="alert alert-warning"><p>{{session('warning')}}</p></div>
@endif