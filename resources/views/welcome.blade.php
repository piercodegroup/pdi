@extends('layouts.app')

@section('content')
<main class="main mt-14 m-auto bg-[url('../assets/images/logo-background.png')] bg-no-repeat bg-contain">
    <section class="section-inicio relative w-[80vw] m-auto">
        <aside class="aside-text-content">
            <h1
                class="text-6xl whitespace-pre-line w-[30rem] font-black bg-clip-text text-transparent bg-gradient-to-r from-color-secondary via-color-primary to-color-primary">
                Reviva o
                Sabor das Boas
                Memórias!
            </h1>
            <p class="text-xl text-color-secondary w-[35rem] mt-2">Sinta o aconchego das manhãs de antigamente com pães
                e
                doces que trazem de volta memórias queridas.</p>
        </aside>
        <aside class="aside-buttons mt-10 flex gap-2">
            <button
                class="bg-color-primary text-white hover:opacity-95 transition-opacity font-semibold py-3 w-52 rounded-xl"><a
                    href="#" class="flex items-center justify-center gap-2">Descubra o sabor <i
                        class='bx bx-right-arrow-alt text-2xl'></i></a></button>
            <button
                class="bg-transparent text-color-primary border-2 hover:opacity-95 transition-opacity font-semibold border-color-primary py-3 w-52 rounded-xl"><a
                    href="#">Saiba mais</a></button>
        </aside>
        <aside class="aside-info-store flex gap-10 mt-10">
            <div class="info-quantity-products text-color-secondary">
                <h3 class="text-quantity-products text-3xl font-bold">30+</h3>
                <p>Produtos</p>
            </div>
            <div class="info-quantity-flavors text-color-secondary">
                <h3 class="text-quantity-flavors text-3xl font-bold">120+</h3>
                <p>Sabores</p>
            </div>
            <div class="info-quantity-custumers text-color-secondary">
                <h3 class="text-quantity-custumers text-3xl font-bold">1mil+</h3>
                <p>Clientes satisfeitos</p>
            </div>
        </aside>
        <img src="{{ asset('assets/images/products/paes.svg') }}" class="absolute w-[500px] top-0 right-[-150px]">
    </section>
    <section class="section-menu flex flex-col items-center py-14 w-[80vw] m-auto" id="section-menu">
        <h2
            class="title-section text-center text-5xl whitespace-pre-line w-[30rem] font-black bg-clip-text text-transparent bg-gradient-to-r from-color-secondary via-color-primary to-color-primary">
            Nossas delícias</h2>
        <article class="menu-categories flex justify-center gap-5 my-10">
            <div
                class="category pb-10 relative hover:opacity-95 hover:scale-95 cursor-pointer transition-transform h-28 w-28 rounded-xl items-center justify-center shadow-xl bg-color-primary text-sm py-4 text-color-tertiary font-medium text-center flex flex-col">
                <img class="w-16" src="{{ asset('assets/images/products/pao-categoria.png') }}" alt="Pão">
                <h3 class="absolute bottom-3">Pães</h3>
            </div>
            <div
                class="category bg-white pb-10 relative hover:opacity-95 hover:scale-95 cursor-pointer transition-transform h-28 w-28 rounded-xl items-center justify-center shadow-xl bg-color-ligth text-sm py-4 text-color-primary font-medium text-center flex flex-col">
                <img class="w-16" src="{{ asset('assets/images/products/doce-categoria.png') }}" alt="Doce">
                <h3 class="absolute bottom-3">Doces</h3>
            </div>
            <div
                class="category bg-white pb-10 relative hover:opacity-95 hover:scale-95 cursor-pointer transition-transform h-28 w-28 rounded-xl items-center justify-center shadow-xl bg-color-ligth text-sm py-4 text-color-primary font-medium text-center flex flex-col">
                <img class="w-14" src="{{ asset('assets/images/products/salgado-categoria.png') }}" alt="Doce">
                <h3 class="absolute bottom-3">Salgados</h3>
            </div>
            <div
                class="category bg-white pb-10 relative hover:opacity-95 hover:scale-95 cursor-pointer transition-transform h-28 w-28 rounded-xl items-center justify-center shadow-xl bg-color-ligth text-sm py-4 text-color-primary font-medium text-center flex flex-col">
                <img class="w-[4.5rem]" src="{{ asset('assets/images/products/bebidas-categoria.png') }}" alt="Doce">
                <h3 class="absolute bottom-3">Bebidas</h3>
            </div>
            <div
                class="category bg-white pb-10 relative hover:opacity-95 hover:scale-95 cursor-pointer transition-transform h-28 w-28 rounded-xl items-center justify-center shadow-xl bg-color-ligth text-sm py-4 text-color-primary font-medium text-center flex flex-col">
                <img class="w-16" src="{{ asset('assets/images/products/mantimentos-categoria.png') }}" alt="Doce">
                <h3 class="absolute bottom-3">Mantimentos</h3>
            </div>
        </article>
        <aside class="aside-products flex gap-7">
            <div
                class="product hover:cursor-pointer hover:scale-95 transition-transform w-60 h-60 p-6 justify-between bg-white rounded-xl shadow-xl flex flex-col items-center">
                <img src="{{ asset('assets/images/products/paes/pao-frances.png') }}" class="h-28" alt="">
                <div class="product-info w-full relative">
                    <span class="flag-popular bg-color-tertiary text-white font-medium text-sm px-3 rounded-full">Mais
                        vendido</span>
                    <h3 class="text-md">Pão Francês</h3>
                    <h2 class="price text-md font-bold">R$0.75</h2>
                    <button
                        class="button-add-item-to-bag absolute bottom-2 right-0 h-10 w-10 rounded-full bg-color-secondary text-white"><i
                            class='bx bx-shopping-bag text-xl'></i></button>
                </div>
            </div>

            <div
                class="product hover:cursor-pointer hover:scale-95 transition-transform w-60 h-60 p-6 justify-between bg-white rounded-xl shadow-xl flex flex-col items-center">
                <img src="{{ asset('assets/images/products/paes/pao-italiano.png') }}" class="h-28" alt="">
                <div class="product-info w-full relative">
                    <span class="flag-popular bg-color-tertiary text-white font-medium text-sm px-3 rounded-full">Mais
                        vendido</span>
                    <h3 class="text-md">Pão Italiano</h3>
                    <h2 class="price text-md font-bold">R$0.75</h2>
                    <button
                        class="button-add-item-to-bag absolute bottom-2 right-0 h-10 w-10 rounded-full bg-color-secondary text-white"><i
                            class='bx bx-shopping-bag text-xl'></i></button>
                </div>
            </div>

            <div
                class="product hover:cursor-pointer hover:scale-95 transition-transform w-60 h-60 p-6 justify-between bg-white rounded-xl shadow-xl flex flex-col items-center">
                <img src="{{ asset('assets/images/products/paes/pao-hamburguer.png') }}" class="h-28" alt="">
                <div class="product-info w-full relative">
                    <span class="flag-popular bg-color-tertiary text-white font-medium text-sm px-3 rounded-full">Mais
                        vendido</span>
                    <h3 class="text-md">Pão Hambúrguer</h3>
                    <h2 class="price text-md font-bold">R$0.75</h2>
                    <button
                        class="button-add-item-to-bag absolute bottom-2 right-0 h-10 w-10 rounded-full bg-color-secondary text-white"><i
                            class='bx bx-shopping-bag text-xl'></i></button>
                </div>
            </div>

            <div
                class="product hover:cursor-pointer hover:scale-95 transition-transform w-60 h-60 p-6 justify-between bg-white rounded-xl shadow-xl flex flex-col items-center">
                <img src="{{ asset('assets/images/products/paes/pao-caseiro.png') }}" class="h-28" alt="">
                <div class="product-info w-full relative">
                    <span class="flag-popular bg-color-tertiary text-white font-medium text-sm px-3 rounded-full">Mais
                        vendido</span>
                    <h3 class="text-md">Pão Caseiro</h3>
                    <h2 class="price text-md font-bold">R$0.75</h2>
                    <button
                        class="button-add-item-to-bag absolute bottom-2 right-0 h-10 w-10 rounded-full bg-color-secondary text-white"><i
                            class='bx bx-shopping-bag text-xl'></i></button>
                </div>
            </div>
        </aside>
        <button
            class="button-show-all-products hover:opacity-95 transition-opacity py-3 px-8 mt-14 rounded-xl font-medium bg-color-primary text-white">
            <a href="{{ route('produtos.index') }}">Mostrar mais</a>
        </button>
    </section>
    <section class="section-contato flex p-24 justify-between">
        <aside class="content z-10">
            <h1
                class="text-6xl h-32 font-black bg-clip-text text-transparent bg-gradient-to-r from-color-secondary via-color-primary to-color-primary">
                Envie-nos <br> uma mensagem
            </h1>
            <p class="text-zinc-500 w-96">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam dolorum
                vel fuga dolor quibusdam nesciunt esse doloremque.</p>
        </aside>
        <form>
            <div class="input-group flex flex-col gap-4">
                <div class="input-block text-color-secondary">
                    <input type="text"
                        class="outline-none border border-color-secondary placeholder:text-color-secondary p-4 w-96 rounded-xl"
                        id="name" placeholder="Seu nome">
                </div>
                <div class="input-block">
                    <input type="text"
                        class="outline-none border border-color-secondary placeholder:text-color-secondary p-4 w-96 rounded-xl"
                        id="email" placeholder="Seu e-mail">
                </div>
                <div class="input-block">
                    <textarea name="message"
                        class="outline-none border border-color-secondary placeholder:text-color-secondary resize-none p-4 w-96 rounded-xl"
                        id="message" cols="30" rows="5" placeholder="Sua mensagem"></textarea>
                </div>
            </div>
            <button
                class="button-submit-message w-96 p-4 bg-color-primary text-white font-bold rounded-xl mt-6  hover:opacity-95 cursor-pointer transition-opacity">Enviar</button>
        </form>
    </section>
    <section class="newsletter py-14 flex justify-between gap-10 items-center w-[80vw] m-auto">
        <h1
            class="text-6xl flex-1  font-black bg-clip-text text-transparent bg-gradient-to-r from-color-secondary via-color-primary to-color-primary">
            Increva-se <br>
            na nossa
            Newsletter
        </h1>
        <div>
            <p class="w-96 text-zinc-500 mb-5">Receba as promoções diretamente no seu <br> e-mail. Além de receitas e
                dicas
                especiais para você testar no conforto
                da sua casa.</p>
            <div class="input-block flex h-16">
                <input type="text" placeholder="Digite seu melhor e-mail"
                    class="p-4 border border-color-secondary text-color-secondary placeholder:text-current outline-none flex-1 rounded-l-xl w-96">
                <button
                    class="button-subscribe-newsletter hover:opacity-95 cursor-pointer transition-opacity rounded-r-xl text-white font-bold bg-color-primary px-6">Increver-se</button>
            </div>
        </div>
    </section>
    <button
        class="button-to-up fixed z-20 right-4 bottom-4 shadow-xl hover:opacity-95 transition-all hover:scale-95 w-14 h-14 rounded-xl bg-color-primary flex items-center justify-center text-white text-3xl"><i
            class='bx bx-chevron-up'></i>
    </button>
</main>
<footer class="border-t py-14 border-color-primary w-screen relative overflow-hidden">
    <div class="container w-[80vw] m-auto text-zinc-500">
        <div
            class="flex items-center justify-between bg-[url('../assets/images/logo-background.png')] bg-contain bg-no-repeat">
            <div class="flex flex-col gap-5 z-20">
                <div class="collum">
                    <div>
                        <img src="{{ asset('assets/images/logo.svg') }}" class="w-44 h-24 object-cover"
                            alt="Logo Padoca Dona Ines">
                        <p></p>
                    </div>
                    <p class="about w-96">

                        Somos uma padaria acolhedora que oferece pães fresquinhos, doces caseiros e um atendimento
                        cheio de carinho, sendo o <span class="text-color-primary font-medium">lugar ideal para quem
                            aprecia a
                            tradição e o sabor.</span>
                    </p>
                    <p class="mt-5"><span class="text-color-primary font-medium"><i class='bx bx-building-house'></i>
                            Fatec
                            Lins</span> <br> Estrada Mário Covas Junior, km 1 - Vila Guararapes, <br> Lins - SP,
                        16403-025</p>
                </div>
                <div class="flex">
                    <div class="socials">
                        <h3 class="mb-3 font-bold text-color-primary text-2xl">Siga-nos nas redes socias</h3>
                        <div class="flex gap-2">
                            <div
                                class="icon hover:opacity-95 transition-opacity cursor-pointer w-12 text-white h-12 text-2xl flex justify-center items-center rounded-full bg-color-primary">
                                <a href="" class="w-max h-max flex items-center"><i class='bx bxl-instagram'></i></a>
                            </div>
                            <div
                                class="icon hover:opacity-95 transition-opacity cursor-pointer w-12 text-white h-12 text-2xl flex justify-center items-center rounded-full bg-color-primary">
                                <a href="" class="w-max h-max flex items-center"><i
                                        class='bx bxl-pinterest-alt'></i></a>
                            </div>
                            <div
                                class="icon hover:opacity-95 transition-opacity cursor-pointer w-12 text-white h-12 text-2xl flex justify-center items-center rounded-full bg-color-primary">
                                <a href="" class="w-max h-max flex items-center"><i class='bx bxl-youtube'></i></a>
                            </div>
                            <div
                                class="icon hover:opacity-95 transition-opacity cursor-pointer w-12 text-white h-12 text-2xl flex justify-center items-center rounded-full bg-color-primary">
                                <a href="" class="w-max h-max flex items-center"><i class='bx bxl-tiktok'></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="columns flex z-20 justify-between items-center">
                    <div class="column p-4 w-44">
                        <h3 class="font-bold text-xl text-color-primary mb-2">Sobre</h3>
                        <ul>
                            <li class="hover:text-color-secondary hover:font-medium transition-all hover:ml-2 "><a
                                    href="">Sobre
                                    nós</a></li>
                            <li class="hover:text-color-secondary hover:font-medium transition-all hover:ml-2 "><a
                                    href="">Serviços</a></li>
                            <li class="hover:text-color-secondary hover:font-medium transition-all hover:ml-2 "><a
                                    href="">Contato</a></li>
                            <li class="hover:text-color-secondary hover:font-medium transition-all hover:ml-2 "><a
                                    href="">Nossas
                                    lojas</a></li>
                        </ul>
                    </div>
                    <div class="column p-4 w-44">
                        <h3 class="font-bold text-xl text-color-primary mb-2">Pedidos</h3>
                        <ul>
                            <li class="hover:text-color-secondary hover:font-medium transition-all hover:ml-2 "><a
                                    href="">Menu</a>
                            </li>
                            <li class="hover:text-color-secondary hover:font-medium transition-all hover:ml-2 "><a
                                    href="">Pedidos
                                    on-line</a></li>
                            <li class="hover:text-color-secondary hover:font-medium transition-all hover:ml-2 "><a
                                    href="">Promoções</a></li>
                            <li class="hover:text-color-secondary hover:font-medium transition-all hover:ml-2 "><a
                                    href="">Delivery</a></li>
                        </ul>
                    </div>
                    <div class="column p-4 w-44 z-10">
                        <h3 class="font-bold text-xl text-color-primary mb-2">Ajuda</h3>
                        <ul>
                            <li class="hover:text-color-secondary hover:font-medium transition-all hover:ml-2 "><a
                                    href="">Ajuda</a>
                            </li>
                            <li class="hover:text-color-secondary hover:font-medium transition-all hover:ml-2 "><a
                                    href="">Suporte</a></li>
                            <li class="hover:text-color-secondary hover:font-medium transition-all hover:ml-2 "><a
                                    href="">Dúvidas</a></li>
                            <li class="hover:text-color-secondary hover:font-medium transition-all hover:ml-2 "><a
                                    href="">Configurações</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{ asset('assets/images/backgrounds/11.png') }}"
            class="w-96 h-96 object-cover absolute bottom-[-60px] right-0 z-0 opacity-95" alt="">
    </div>
    <p class="text-center pt-10 text-zinc-400">Copyright <i class='bx bx-copyright'></i> Padoca Dona Inês Desenvolvido
        com <i class='bx bxs-heart'></i> | 2024</p>
</footer>
@endsection