@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

<nav class="main-header navbar navbar-expand-lg navbar-dark" style="background-color: var(--blue-2);">
    <!-- Azul marinho escuro -->
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
            <form action="{{ route('filtro.prefeitura') }}" method="POST" id="prefeitura-form"
                class="d-flex align-items-center">
                @csrf
                <label for="prefeitura" class="text-white mb-0 mr-2 text-nowrap">Selecione a Prefeitura:</label>
                <select class="form-control" id="prefeitura" name="prefeitura_id" required
                    onchange="document.getElementById('prefeitura-form').submit();"
                    style="border-radius: 5px; max-width: 250px;">
                    <option value="99" {{ session('prefeitura_id') == 99 ? 'selected' : '' }}>TODAS</option>
                    @foreach (session('prefeituras', []) as $prefeitura)
                        <option value="{{ $prefeitura['id'] }}"
                            {{ session('prefeitura_id') == $prefeitura['id'] ? 'selected' : '' }}>
                            {{ $prefeitura['razao_social'] }}
                        </option>
                    @endforeach
                </select>
            </form>


            {{-- Custom right links --}}
            @yield('content_top_nav_right')

            {{-- Configured right links --}}
            @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

            {{-- User menu link --}}
            @if (Auth::user())
                @if (config('adminlte.usermenu_enabled'))
                    @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
                @else
                    @include('adminlte::partials.navbar.menu-item-logout-link')
                @endif
            @endif

            {{-- Right sidebar toggler link --}}
            @if ($layoutHelper->isRightSidebarEnabled())
                @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
            @endif
        </ul>
    </div>
</nav>
