@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
@endpush

@section('adminlte_css')
<style>
    .main-sidebar {
        background-color: var(--blue-2) !important;
    }
    .main-sidebar .nav-link {
        color: #fff !important;
    }
    .main-sidebar .nav-link:hover {
        color: #fff !important;
    }
    .main-sidebar .nav-link.active {
        color: #fff !important;
    }
    .nav-sidebar>.nav-item>.nav-link.active{
        background-color: var(--blue-1) !important;
    }
    .nav-treeview>.nav-item>.nav-link.active {
        background-color: #fff !important;
        color: var(--blue-1) !important;
    }
    .nav-treeview>.nav-item>.nav-link.active:hover {
        background-color: var(--blue-1);
    }
    .brand-link {
        text-decoration: none;
        color: #fff !important;
    }
    .bluebtn{
        background-color: var(--blue-1) !important;
        color: #fff !important;
        transition: 0.2s
    }
    .bluebtn:hover{
        background-color: var(--blue-2) !important;
    }
    .label-control{
    text-align: right
  }
  .card-footer {
        text-align: right
    }
  @media (max-width: 768px) {
      .label-control{
        text-align: start
      }
    }
</style>
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Preloader Animation (fullscreen mode) --}}
        @if($preloaderHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')

    @stack('js')
    @yield('js')
@stop
