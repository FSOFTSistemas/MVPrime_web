@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

<nav class="main-header navbar navbar-expand-lg navbar-dark" style="background-color: var(--blue-2);">  <!-- Azul marinho escuro -->
    <div class="container-fluid">
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
            <form action="{{ route('filtro.prefeitura') }}" method="POST" class="form-inline ml-2 d-flex justify-content-center align-items-center">
                @csrf
                <div class="input-group input-group-sm align-items-center">
                    <div class="input-group-prepend mr-2">
                        <span class="input-group-text border-0 p-0 pr-2" style="font-size: 0.875rem; background-color: transparent">
                            <label for="prefeitura_id" class="mb-0" style="font-size: 16px; color: #fff; font-weight: 400;">Prefeitura:</label>
                        </span>
                    </div>
                    <select class="form-control" id="prefeitura" name="prefeitura_id" required onchange="this.form.submit()" style="border-radius: 5px;">
                        <option value="">Selecione...</option>
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
    </div>
</nav>
