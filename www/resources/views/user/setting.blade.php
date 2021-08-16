@extends('../home')

@section('content')
    <div class="container">
        <div class="col-md-8">
            <form action="changeInf" method="get" class="form-actions">
                <h2>Kontaktné informaci</h2><br>
                Meno: <input disabled class="form-control col-md-8" type="text" value="{{Auth::user()->name}}"><br>
                Priezvisko: <input disabled class="form-control col-md-8" type="text" value="{{Auth::user()->surname}}"><br>
                E-mail: <input name="mail" class="form-control col-md-8" type="email" value="{{Auth::user()->email}}"><br>
                <button style="margin-top: 5px" type="submit" class="btn btn-icon btn-primary glyphicons circle_ok">
                    <i></i>Zmeniť údaje
                </button>
            </form>
        </div>
        <div class="col-md-4">

            <h2>Zmena hesla</h2><br>
            <div class="form-actions" style="margin: 0;">
                <form action="safePass" method="get" class="form-actions">
                    Staré heslo: <input required class="form-control col-md-4" type="password" name="oldPass"><br>
                    Nové heslo: <input required class="form-control col-md-4" type="password" name="newPass"><br>
                    Potvrdiť heslo: <input required class="form-control col-md-4" type="password" name="confPass"><br>
                    @if(session()->has('wrongPass'))
                        <div>
                            <span style="color: red">{{Session::get('wrongPass')}}</span>
                        </div>
                        <!--                    --><?php Session::forget('wrongPass') ?>
                    @endif
                    @if(session()->has('goodPass'))
                        <div>
                            <span style="color:green">{{Session::get('goodPass')}}</span>
                        </div>
                        <!--                    --><?php Session::forget('goodPass') ?>
                    @endif

                    <button style="margin-top: 5px" type="submit" class="btn btn-icon btn-primary glyphicons circle_ok">
                        <i></i>Zmeniť heslo
                    </button>
                </form>
            </div>


        </div>
        @if(Auth::user()->getRights(Auth::user()->id)==2 || Auth::user()->getRights(Auth::user()->id)==1)
        <div style="margin-top: 20px" class="col-md-8">
            <form action="changeInf" method="get" class="form-actions">
                <h2>Priradovací kód</h2><br>
                Kód: <input disabled class="form-control col-md-8" type="text" value="{{Auth::user()->ucto_code}}"><br>
            </form>
        </div>
            @endif
    </div>
@endsection