<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info" style="background-color: #E0E0E0">
        <br>
        <div class="image">
            <img src="{{ url('images/logoSideBar.png') }}" width="55" height="55" alt="User" style="border: 3px solid #008080; background: #fff;">
        </div>
        <div class="info-container" style="background-color: #E0E0E0">
        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i><strong>{{ strtoupper(Auth::user()->name) }}</strong></i></div>
            <!-- <i><div class="email" style="background-color: #dde7e5">{{ Auth::user()->email  }} </div></i> -->
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">input</i>
                <ul class="dropdown-menu pull-right">
                    <!-- <li><a href="{{ url('password-change') }}"><i class="material-icons">person</i>Ver perfil</a></li> -->
                    <li id="limpiar"><a href="{{ url('logout') }}"><i class="material-icons">input</i>Cerrar sesión</a></li> 
                </ul>
            </div>
        </div>   
    </div>
    <br>
    <!-- #User Info -->

    <!-- Menu -->
    <div class="menu" style="background-color: #E0E0E0; margin-top: -5%;">
        <ul class="list">
            <!-- <li class="header" style="background-color: #E0E0E0">MENÚ PRINCIPAL</li> -->
            <li @if(Route::currentRouteName()=='' ) class="active" @endif>
                <a href="{{ url('/') }}">
                    <i class="material-icons">dashboard</i>
                    <span>Dashboard</span>
                </a>
            </li>

            @php
            $side_menu = Session::get('side_menu');
            @endphp

            @foreach($side_menu[0] as $value)
                @if(count($value['sub_menu'])>0)
                    <li class="parent">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">{{ $value['icon'] }}</i>
                            <span>{{ $value['name'] }}</span>
                        </a>
                        <ul class="ml-menu">
                            @foreach($value['sub_menu'] as $sub)
                                <li @if(Route::currentRouteName()==$sub->menu_url) class="active" @endif>
                                    <a href="{{ $sub->menu_url ? route($sub->menu_url) : '' }}">
                                        <span>{{ $sub->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li @if(Route::currentRouteName()==$value['url']) class="active" @endif>
                        <a href="{{ $value['url'] ? route($value['url']) : '' }}">
                            <i class="material-icons">{{ $value['icon'] }}</i>
                            <span>{{ $value['name'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach()
        </ul>
    </div>
    <style>
        @keyframes zoom {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.3);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</aside>
<!-- #END# Left Sidebar -->

<script>

    // Obtener la sede del usuario
    //var userEmail = "{{ Auth::user()->email }}";
    var userSede = "{{ Auth::user()->place }}";
    var userRoles = "{{ Auth::user()->roles }}";

    //saber el lugar/sede
    if(userSede == "todo"){
        localStorage.setItem("sede", "bodega_central");
    }else if(userSede == "linares"){
        localStorage.setItem("sede", "linares");
    }else if(userSede == "molina"){
        localStorage.setItem("sede", "molina");
    }else{
        localStorage.setItem("sede", "ninguno");
    }

    //saber el rol del usuario del sistema
    if(userRoles == "encargado"){
        localStorage.setItem("rol", "encargado");
    }else if(userRoles == "jefetaller"){
        localStorage.setItem("rol", "jefetaller");
        //localStorage.setItem("reporte", "");
    }else if(userRoles == "maestro"){
        localStorage.setItem("rol", "maestro");
    }else{
        localStorage.setItem("rol", "administrador");
        //localStorage.setItem("reporte", "");
    }

    // Seleccionar el elemento con el ID "limpiar" para borrar el localStorage cuando clickea Cerrar Sesión
    const limpiarBtn = document.getElementById('limpiar');
    // Agregar el event listener al clic
    limpiarBtn.addEventListener('click', () => {
        // Limpiar el localStorage
        localStorage.clear();
        //console.log('Se ha limpiado el localStorage');
    });
</script>