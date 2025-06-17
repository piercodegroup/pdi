<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - Padoca Dona Inês</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="{{ asset('js/tailwind.config.js') }}"></script>
  <!-- Boxicons for Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <!-- Global CSS -->
  <link rel="stylesheet" href="{{ asset('assets/styles/global.css') }}">
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="font-sans">
  <section class="flex justify-between">
    <section class="section-cadastro w-full lg:w-[50vw] h-screen flex items-center p-4 lg:px-28 bg-white">
      <form method="POST" action="{{ route('register') }}" class="cadastro-container w-full max-w-md mx-auto">
        @csrf
        
        <h1 class="m-auto font-black text-4xl lg:text-6xl text-center bg-clip-text text-transparent bg-gradient-to-b from-color-secondary to-color-primary">
          Bem-vindo!
        </h1>
        <p class="text-zinc-400 mt-2 lg:text-center">Complete seu cadastro para acessar o melhor da nossa padaria e ficar por dentro das novidades.</p>
        
        <div class="input-block flex flex-col mt-6">
          <!-- Nome -->
          <div class="input-container py-4 px-6 rounded-xl text-color-secondary flex bg-color-light">
            <input type="text" name="nome" id="nome" placeholder="Digite seu nome"
              class="bg-transparent placeholder:text-current flex-1 outline-none" value="{{ old('nome') }}" required autofocus>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-user-round h-5 w-5">
              <circle cx="12" cy="8" r="5" />
              <path d="M20 21a8 8 0 0 0-16 0" />
            </svg>
          </div>
          @error('nome')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror

          <!-- Email -->
          <div class="input-container mt-2 py-4 px-6 rounded-xl text-color-secondary flex bg-color-light">
            <input type="email" name="email" id="email" placeholder="Digite seu e-mail"
              class="bg-transparent placeholder:text-current flex-1 outline-none" value="{{ old('email') }}" required>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-at-sign h-5 w-5">
              <circle cx="12" cy="12" r="4" />
              <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8" />
            </svg>
          </div>
          @error('email')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror

          <!-- Senha -->
          <div class="input-container mt-2 py-4 px-6 rounded-xl text-color-secondary flex bg-color-light">
            <input type="password" name="password" id="password" placeholder="Crie sua senha"
              class="bg-transparent placeholder:text-current flex-1 outline-none" required>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-eye-closed cursor-pointer button-show-password h-5 w-5">
              <path d="m15 18-.722-3.25" />
              <path d="M2 8a10.645 10.645 0 0 0 20 0" />
              <path d="m20 15-1.726-2.05" />
              <path d="m4 15 1.726-2.05" />
              <path d="m9 18 .722-3.25" />
            </svg>
          </div>
          @error('password')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror

          <!-- Confirmação de Senha -->
          <div class="input-container mt-2 py-4 px-6 rounded-xl text-color-secondary flex bg-color-light">
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirme sua senha"
              class="bg-transparent placeholder:text-current flex-1 outline-none" required>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-lock h-5 w-5">
              <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
              <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            </svg>
          </div>

          <!-- Telefone -->
          <div class="input-container mt-2 py-4 px-6 rounded-xl text-color-secondary flex bg-color-light">
            <input type="text" name="telefone" id="telefone" placeholder="Telefone (com DDD)"
              class="bg-transparent placeholder:text-current flex-1 outline-none" value="{{ old('telefone') }}" required>
            <i class='bx bx-phone text-xl'></i>
          </div>
          @error('telefone')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror

          <!-- CPF -->
          <div class="input-container mt-2 py-4 px-6 rounded-xl text-color-secondary flex bg-color-light">
            <input type="text" name="cpf" id="cpf" placeholder="CPF (apenas números)"
              class="bg-transparent placeholder:text-current flex-1 outline-none" value="{{ old('cpf') }}" required>
            <i class='bx bx-id-card text-xl'></i>
          </div>
          @error('cpf')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror
        </div>

        <button type="submit"
          class="button-submit-data-register w-full p-4 mt-6 font-bold text-white bg-color-primary rounded-xl hover:opacity-95">
          Criar Conta
        </button>
        
        <p class="mt-4 text-center text-zinc-400">Já possui uma conta? 
          <a href="{{ route('login') }}" class="text-color-primary font-bold">Faça login</a>
        </p>
      </form>
    </section>

    <aside class="image-side hidden lg:block relative bg-[url('../assets/images/background-register.png')] bg-cover bg-center w-[50vw] h-screen z-10">
      <img src="{{ asset('assets/images/logo-white-sm.png') }}" class="absolute bottom-6 right-6 logo" alt="Logo Padaria">
    </aside>
  </section>

  <!-- Scripts -->
  <script>
    // Mostrar/ocultar senha
    document.querySelectorAll('.button-show-password').forEach(button => {
      button.addEventListener('click', function() {
        const input = this.parentElement.querySelector('input');
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        this.classList.toggle('lucide-eye');
        this.classList.toggle('lucide-eye-closed');
      });
    });

    // Máscara para CPF
    document.getElementById('cpf').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length > 3 && value.length <= 6) {
        value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
      } else if (value.length > 6 && value.length <= 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
      } else if (value.length > 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
      }
      e.target.value = value;
    });

    // Máscara para telefone
    document.getElementById('telefone').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length > 0 && value.length <= 2) {
        value = `(${value}`;
      } else if (value.length > 2 && value.length <= 7) {
        value = value.replace(/(\d{2})(\d{1,5})/, '($1) $2');
      } else if (value.length > 7) {
        value = value.replace(/(\d{2})(\d{5})(\d{1,4})/, '($1) $2-$3');
      }
      e.target.value = value;
    });
  </script>
</body>

</html>