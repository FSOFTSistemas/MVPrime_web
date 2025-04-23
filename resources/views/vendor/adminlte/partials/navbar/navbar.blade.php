@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        <form action="{{ route('filtro.prefeitura') }}" method="POST" class="form-inline ml-2">
            @csrf
            <div class="col-md-6 mb-3">
                <label for="prefeitura_id" class="form-label">Prefeitura</label>
                <select class="form-control" id="prefeitura" name="prefeitura_id" required
                    onchange="this.form.submit()">
                    <option value="">Selecione uma Prefeitura</option>
                    @foreach (session('prefeituras', []) as $prefeitura)
                        <option value="{{ $prefeitura['id'] }}" {{ session('prefeitura_selecionada') == $prefeitura['id'] ? 'selected' : '' }}>
                            {{ $prefeitura['razao_social'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>