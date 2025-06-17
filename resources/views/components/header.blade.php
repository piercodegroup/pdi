<header class="header border-b border-color-secondary">
    <div class="header-container flex items-center justify-evenly px-10">
        <section class="section-logo-header-container">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo Padoca Dona Inês" class="h-[5rem]">
            </a>
        </section>

        <nav class="navbar">
            <ul class="navbar-menu flex gap-3 text-color-secondary">
                <li class="navbar-item {{ request()->is('/') ? 'text-color-primary font-bold' : '' }}"><a
                        href="{{ route('home') }}">Início</a></li>
                <li class="navbar-item"><a href="{{ route('produtos.index') }}">Produtos</a></li>
                <li class="navbar-item"><a href="#">Sobre</a></li>
                <li class="navbar-item"><a href="#">Contato</a></li>
            </ul>
        </nav>

        <section class="section-assets-header-container flex gap-4">

            @auth('cliente')

            <button class="button-bag bg-color-light rounded-full w-12 h-12 flex items-center justify-center relative">
                @auth('cliente')
                <span
                    class="bag-items-text absolute top-0 right-0 bg-color-primary text-white rounded-full w-6 h-6 flex justify-center items-center">
                    {{ auth('cliente')->user()->sacolaAtiva?->itens->count() ?? 0 }}
                </span>
                @endauth
                <a href="{{ route('sacola.index') }}"><i
                        class='bx bx-shopping-bag text-color-secondary text-xl'></i></a>
            </button>

            
            <button class="button-orders bg-color-light rounded-full w-12 h-12 flex items-center justify-center">
                <a href="{{ route('pedidos.index') }}"><i class='bx bx-history text-color-secondary text-xl'></i></a>
            </button>

            <div class="dropdown relative">
                <button class="button-profile bg-color-light rounded-full w-12 h-12 flex items-center justify-center">
                    <i class='bx bx-user text-color-secondary text-xl'></i>
                </button>
                <div class="dropdown-menu absolute hidden right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                    <a href="{{ route('perfil') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Meu
                        Perfil</a>
                    <a href="{{ route('perfil.enderecos') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Endereços</a>
                    <a href="{{ route('perfil.cartoes') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cartões</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sair</button>
                    </form>
                </div>
            </div>
            @else
            <button class="button-login bg-color-light rounded-full w-12 h-12 flex items-center justify-center">
                <a href="{{ route('login') }}"><i class='bx bx-user text-color-secondary text-xl'></i></a>
            </button>
            @endauth
        </section>
    </div>
</header>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileButton = document.querySelector('.button-profile');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    if (profileButton && dropdownMenu) {
        profileButton.addEventListener('click', function(e) {
            e.preventDefault();
            dropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                dropdownMenu.classList.add('hidden');
            }
        });
    }
});
</script>

@endpush