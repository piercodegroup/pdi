<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Padoca Dona Inês</title>
  
  <!-- script-tailwind-css -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="{{ asset('js/tailwind.config.js') }}"></script>

  <!-- link-bx-icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

  <!-- link-css -->
  <link rel="stylesheet" href="{{ asset('assets/styles/global.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

</head>

<body class="font-sans overflow-hidden flex justify-between">
  <aside class="hidden lg:block w-[50vw] h-screen bg-cover bg-bottom relative" style="background-image: url('{{ asset('assets/images/background-login.png') }}')">
    <img src="{{ asset('assets/images/logo-white-sm.svg') }}" class="absolute bottom-6 left-6 w-1/2 lg:w-auto" alt="">
  </aside>
  <section class="section-login w-full lg:w-[50vw] h-screen flex flex-col justify-center px-6 sm:px-16 md:px-28">
    <div class="login-container w-full max-w-md mx-auto">
      <div class="login-container w-full max-w-md mx-auto">
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif
      <h1 class="text-4xl md:text-5xl text-center font-black bg-clip-text text-transparent bg-gradient-to-b from-color-secondary via-color-secondary to-color-primary">
        Acesso <br>
        Administrativo
      </h1>
      <p class="text-zinc-400 mt-4">Área restrita à equipe da Padoca Dona Inês. Faça login para gerenciar o sistema.</p>
      <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div class="input-block flex flex-col mt-6">
          <div class="input-container py-4 px-6 rounded-xl text-color-secondary flex bg-color-light">
            <input type="text" name="email" id="email" placeholder="E-mail"
              class="bg-transparent placeholder:text-current flex-1 outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-at-sign h-5 w-5">
              <circle cx="12" cy="12" r="4" />
              <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8" />
            </svg>
          </div>
          <div class="input-container mt-4 py-4 px-6 rounded-xl text-color-secondary flex bg-color-light">
            <input type="password" name="senha" id="senha" placeholder="Senha"
              class="bg-transparent placeholder:text-current flex-1 outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-eye-closed h-5 w-5 button-show-password cursor-pointer">
              <path d="m15 18-.722-3.25" />
              <path d="M2 8a10.645 10.645 0 0 0 20 0" />
              <path d="m20 15-1.726-2.05" />
              <path d="m4 15 1.726-2.05" />
              <path d="m9 18 .722-3.25" />
            </svg>
          </div>
        </div>
        <aside class="aside-options flex justify-between mt-3">
          <div class="input-block text-[13px] md:text-base flex gap-1 items-center text-zinc-400">
            <input type="checkbox" name="remember" id="remember" class="p-4 cursor-pointer">
            <p>Lembrar de mim</p>
          </div>
          <button type="button" class="text-color-primary font-bold text-[13px] md:text-base">Esqueceu sua senha?</button>
        </aside>
        <button type="submit" id="button-submit-login"
          class="button-submit-login transition-opacity hover:opacity-95 w-full p-4 rounded-xl bg-color-primary text-white font-bold mt-16">Entrar</button>
      </form>
    </div>
  </section>

  <script>
    // Toggle para mostrar/esconder senha
    document.querySelector('.button-show-password').addEventListener('click', function() {
      const passwordInput = document.getElementById('senha');
      const icon = this;
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.replace('lucide-eye-closed', 'lucide-eye');
      } else {
        passwordInput.type = 'password';
        icon.classList.replace('lucide-eye', 'lucide-eye-closed');
      }
    });
  </script>
</body>

</html>