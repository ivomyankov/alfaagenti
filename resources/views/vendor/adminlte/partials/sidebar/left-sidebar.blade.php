<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        @if(Auth::user())
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image"><img src="{{ URL::to('/') }}/images/agenti/{{Auth::user()->profile_img}}" style="width:50px" class="img-circle elevation-2" alt="User Image">
            </div> {{-- mix(config('adminlte.logo_user',  Auth::user()->profile_img)) --}}        
          <a class="nav-link href="#" class="d-block">{{ Auth::user()->name }}</a>          
        </div>
        @endif
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>

            
                <li class="nav-item has-treeview ">    
                    <a class="nav-link  " href="">
                        <img src="{{ URL::to('/') }}/images/agenti/{{Auth::user()->profile_img}}" style="width:50px; margin-right:10px;" class="img-circle elevation-2" alt="User Image">
                        {{-- mix(config('adminlte.logo_user',  Auth::user()->profile_img)) --}}
                        <p>{{ Auth::user()->name }}
                            <i class="fas fa-angle-left right" style="top:25px;"></i></p>
                    </a>    
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
			                <a class="nav-link  " href="#">
				                <i class="far fa-fw fa-circle "></i>
				                <p>Level 3</p>
			                </a>
		                </li>
		                <li class="nav-item">
			                <a class="nav-link  " href="#">
				                <i class="far fa-fw fa-circle "></i>
				                <p>Level 3</p>
			                </a>
		                </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ URL::route('dashboard') }}">
                        <i class="fas fa-fw fa-chart-pie "></i>
                        <p>Табло</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ URL::route('dashImoti') }}">
                        <i class="fas fa-fw fa-home "></i>
                        <p>Имоти</p>
                        <span class="badge bg-purple right" style="right: 45px;">{{$stats['all']}}</span>
                        <span class="badge bg-primary right">{{$stats['mine']}}</span>
                    </a>
                </li>
                @if($stats['agent']->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('agenti') }}">
                        <i class="fas fa-fw fa-users "></i>
                        <p>Агенти</p>
                        <span class="badge badge-success right">{{$stats['agents']}}</span>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/alfaagenti/public/admin/settings">
                        <i class="fas fa-fw fa-user "></i>
                        <p>Профил</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/alfaagenti/public/admin/settings">
                        <i class="fas fa-fw fa-tools "></i>
                        <p>Настройки</p>
                    </a>
                </li>
                {{-- Configured sidebar links
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')  --}}
            </ul>
        </nav>
    </div>

</aside>
