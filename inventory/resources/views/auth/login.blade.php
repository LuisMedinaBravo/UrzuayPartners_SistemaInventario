<!DOCTYPE html>
<html>
<head>
	<title>Inventario - Urzúa & Partners</title>
	@include('include.header')
</head>
<body class="login-page" style="background: linear-gradient(to bottom, #ffffff, #ffffff, #cccccc, #b3b3b3, #999999); height: 100vh;">
    <div class="login-box">
        <div class="logo" style="width: 100%; height: 50%; pointer-events: none;">
            <a href="javascript:void(0);"><img class="img-fluid" src="{{ url('images/tallerlogo.png') }}" alt="logo"> </a>
        </div>
        <div class="card" style="border: 7px solid #ccc; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.6);">
            <div class="body">
                <form id="sign_in" method="POST" action="{{ route('login') }}">
                	  {{ csrf_field() }}
                    <strong><div class="msg">Iniciar sesión</div></strong>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" placeholder="Correo electrónico" required autofocus>
                        </div>
                           @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                               @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 p-t-5">
                            <!-- <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Recuérdame</label>-->
                        </div> 
                        <div class="col-xs-4 text-center" style="display: flex; justify-content: center; align-items: center;">
                            <button class="btn btn-block bg-teal waves-effect" type="submit">Ingresar</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            <!-- <a href="sign-up.html">Register Now!</a> -->
                        </div>
                        <!--<div class="col-xs-6 align-right">
                            <a href="href="{{ route('password.request') }}"">¿Olvidaste tu contraseña?</a>
                        </div>-->
                    </div>
                </form>
            </div>
        </div>
    </div>


@include('include.footer')
</body>
<script>
  // Add event listener to the image
  document.querySelector('.logo img').addEventListener('click', function() {
    location.reload();
  });
</script>
</html>