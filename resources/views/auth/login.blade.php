@extends('auth.contenido')

@section('login')
<div class="login-wrap cover">
<div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card-group mb-0">
          <div class="card p-4" style="background:#00000021;">
          <form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}">
          {{ csrf_field() }}
              <div class="card-body text-center">
              <i class="zmdi zmdi-close btn-menu"></i> <a style="font-size: 50px;font-family: 'Ruda', sans-serif;color: #f2f2f2;float: revert;text-transform: uppercase;" class="logo"><b>MEDI<span>SIS</span></b></a>
              <p class="text-muted">Control de acceso al sistema</p>
              <div class="form-group mb-3{{$errors->has('usuario' ? 'is-invalid' : '')}}">
                <span class="input-group-addon" style="background-color: #00ced147;"><i class="icon-user"></i></span>
                <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon" style="background-color: #00ced147;"><i class="icon-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="row" style="margin-left: 30%;">
                <div class="col-6">
                  <button type="submit" class="btn btn-primary form-control ">Acceder</button>
                </div>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
    </div>
@endsection
