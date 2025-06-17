<header class="bg-color-tertiary text-white py-4 px-6 shadow-md">
  <div class="container mx-auto flex justify-between items-center">
    <div class="flex items-center space-x-4">
      <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold">
        <span class="text-color-primary">Padoca</span> Admin
      </a>
    </div>
    
    <div class="flex items-center space-x-6">
      <div class="dropdown relative">
        <button class="flex items-center space-x-2 focus:outline-none">
          <span class="font-medium">{{ auth('admin')->user()->nome }}</span>
          <i class='bx bx-chevron-down'></i>
        </button>
        <div class="dropdown-menu absolute hidden right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 text-gray-700">
          <a href="{{ route('admin.perfil') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Meu Perfil</a>
          <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Sair</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</header>

@push('scripts')
<script>
  // Dropdown do perfil admin
  document.addEventListener('DOMContentLoaded', function() {
    const profileButton = document.querySelector('.dropdown button');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    
    if (profileButton && dropdownMenu) {
      profileButton.addEventListener('click', function(e) {
        e.preventDefault();
        dropdownMenu.classList.toggle('hidden');
      });
      
      // Fechar o dropdown quando clicar fora
      document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
          dropdownMenu.classList.add('hidden');
        }
      });
    }
  });
</script>
@endpush