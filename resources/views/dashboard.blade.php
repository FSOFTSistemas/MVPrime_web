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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1: Empresa -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9l7 7-7 7M3 9l7 7-7 7" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-4">Empresa</h3>
                    <a href="{{ route('empresa.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                </div>

                <!-- Card 2: Prefeira -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 11h18M3 15h18" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-4">Prefeira</h3>
                    <a href="{{ route('prefeira.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                </div>

                <!-- Card 3: Secretarias -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h3m-3 4h3m-3 4h3" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-4">Secretarias</h3>
                    <a href="{{ route('secretarias.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                </div>

                <!-- Card 4: Motoristas -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18M3 18h18" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-4">Motoristas</h3>
                    <a href="{{ route('motoristas.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                </div>

                <!-- Card 5: Veículos -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15h14M5 19h14M7 5h10L12 9" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-4">Veículos</h3>
                    <a href="{{ route('veiculos.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                </div>

                <!-- Card 6: Usuários -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-teal-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-4">Usuários</h3>
                    <a href="{{ route('usuarios.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                </div>

                <!-- Card 7: Postos -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14M5 11h14M5 15h14" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-4">Postos</h3>
                    <a href="{{ route('postos.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                </div>

                <!-- Card 8: Log -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-pink-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-4">Log</h3>
                    <a href="{{ route('log.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                </div>

                <!-- Card 9: Abastecimentos -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-4">Abastecimentos</h3>
                    <a href="{{ route('abastecimentos.index') }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>