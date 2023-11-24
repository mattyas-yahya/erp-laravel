<div class="container">
    <div class="row">
        <div class="col-sm-12">
            @if(Session::has('message'))
                <div class="alert alert-success">
                    {{ Session::get("message") }}
                </div>
            @endif

            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get("error") }}
                </div>
            @endif
        </div>
    </div>
</div>