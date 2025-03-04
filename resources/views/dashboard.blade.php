<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white">
            <div class="p-6">
                <h2 class="text-xl font-semibold">Menu</h2>
                <ul class="mt-4">
                    <li><a href="{{ route('empresa.index') }}" class="hover:text-gray-400">Empresa</a></li>
                    <li><a href="{{ route('prefeira.index') }}" class="hover:text-gray-400">Prefeira</a></li>
                    <li><a href="{{ route('secretarias.index') }}" class="hover:text-gray-400">Secretarias</a></li>
                    <li><a href="{{ route('motoristas.index') }}" class="hover:text-gray-400">Motoristas</a></li>
                    <li><a href="{{ route('veiculos.index') }}" class="hover:text-gray-400">Veículos</a></li>
                    <li><a href="{{ route('usuarios.index') }}" class="hover:text-gray-400">Usuários</a></li>
                    <li><a href="{{ route('postos.index') }}" class="hover:text-gray-400">Postos</a></li>
                    <li><a href="{{ route('log.index') }}" class="hover:text-gray-400">Log</a></li>
                    <li><a href="{{ route('abastecimentos.index') }}" class="hover:text-gray-400">Abastecimentos</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="container mx-auto">
                <div class="row">
                    <!-- Card 1: Empresa -->
                    <div class="col-12 col-sm-6 col-md-3 mb-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-building"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Empresa</span>
                                <a href="{{ route('empresa.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Prefeira -->
                    <div class="col-12 col-sm-6 col-md-3 mb-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-home"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Prefeira</span>
                                <a href="{{ route('prefeira.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Secretarias -->
                    <div class="col-12 col-sm-6 col-md-3 mb-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-building"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Secretarias</span>
                                <a href="{{ route('secretarias.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Motoristas -->
                    <div class="col-12 col-sm-6 col-md-3 mb-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Motoristas</span>
                                <a href="{{ route('motoristas.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5: Veículos -->
                    <div class="col-12 col-sm-6 col-md-3 mb-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-car"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Veículos</span>
                                <a href="{{ route('veiculos.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 6: Usuários -->
                    <div class="col-12 col-sm-6 col-md-3 mb-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users-cog"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Usuários</span>
                                <a href="{{ route('usuarios.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 7: Postos -->
                    <div class="col-12 col-sm-6 col-md-3 mb-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tint"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Postos</span>
                                <a href="{{ route('postos.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 8: Log -->
                    <div class="col-12 col-sm-6 col-md-3 mb-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Log</span>
                                <a href="{{ route('log.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 9: Abastecimentos -->
                    <div class="col-12 col-sm-6 col-md-3 mb-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-gas-pump"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Abastecimentos</span>
                                <a href="{{ route('abastecimentos.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>