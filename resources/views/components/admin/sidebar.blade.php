<aside class="fixed top-0 left-0 z-40 w-20 h-screen bg-white border-r border-gray-200 shadow-sm
             transition-transform duration-300 ease-in-out"
    :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
    
    <div class="h-full flex flex-col items-center justify-between py-4 px-2">

        <div>
            <a href="{{ route('admin.dashboard') }}" class="w-14 h-14">
                <img src="{{ asset('assets/images/logo.svg') }}" class="h-14 w-14" alt="Logo" />
            </a>
        </div>

        <ul class="space-y-3 mt-20 flex-1 flex flex-col items-center">
            @php
                $menuItems = [
                    ['route' => 'admin.dashboard', 'icon' => 'bx-home', 'match' => 'admin/dashboard', 'label' => 'Dashboard'],
                    ['route' => 'admin.pedidos.index', 'icon' => 'bx-package', 'match' => 'admin/pedidos*', 'label' => 'Pedidos'],
                    ['route' => 'admin.produtos.index', 'icon' => 'bx-baguette', 'match' => 'admin/produtos*', 'label' => 'Produtos'],
                    ['route' => 'admin.categorias.index', 'icon' => 'bx-star', 'match' => 'admin/categorias*', 'label' => 'Categorias'],
                    ['route' => 'admin.clientes.index', 'icon' => 'bx-user', 'match' => 'admin/clientes*', 'label' => 'Clientes'],
                    ['route' => 'admin.usuarios.index', 'icon' => 'bx-group', 'match' => 'admin/usuarios*', 'label' => 'Usuários'],
                ];
            @endphp

            @foreach ($menuItems as $item)
                <li class="group relative">
                    <a href="{{ route($item['route']) }}"
                        class="w-14 h-14 flex items-center justify-center rounded-2xl transition
                               {{ request()->is($item['match']) ? 'bg-slate-600 text-white shadow' : ' text-gray-600 hover:bg-orange-100' }}">
                        <i class='bx {{ $item['icon'] }} text-xl'></i>
                    </a>
                    <div class="absolute left-14 top-1/2 -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                        {{ $item['label'] }}
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="flex flex-col items-center space-y-3 border-t border-gray-200 pt-4 w-full">

            <div class="relative group">
                <img src="https://ui-avatars.com/api/?name={{ auth('admin')->user()->nome }}&background=475569&color=fff"
                    class="w-12 h-12 rounded-full shadow cursor-pointer" alt="Perfil">
                <div class="absolute left-14 top-1/2 -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                    {{ auth('admin')->user()->nome }}
                </div>
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                    class="group relative w-12 h-12 flex items-center justify-center rounded-xl bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 transition">
                    <i class='bx bx-log-out text-xl'></i>
                    <div class="absolute left-14 top-1/2 -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                        Sair
                    </div>
                </button>
            </form>

        </div>
    </div>
</aside>

<div class="fixed inset-0 z-30 bg-black bg-opacity-50 sm:hidden"
     x-show="sidebarOpen" @click="sidebarOpen = false"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
</div>
