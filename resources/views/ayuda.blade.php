@extends(\Illuminate\Support\Facades\Auth::user()->userRole()=='admin' ? 'layouts.esqueletoAdmin':'layouts.esqueletoInstalador')

@section('body')
    @if (\Illuminate\Support\Facades\Auth::user()->userRole()=='admin')
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <iframe class="uk-height-large uk-width-expand" src="http://www.youtube.com/embed/Nm6HrAsF7MI"
                                allowfullscreen frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (\Illuminate\Support\Facades\Auth::user()->userRole()=='instalador')
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <iframe class="uk-height-large uk-width-expand" src="http://www.youtube.com/embed/AEkUpsX-q4I"
                                allowfullscreen frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
