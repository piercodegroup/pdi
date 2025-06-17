document.addEventListener('DOMContentLoaded', () => {
    const produtosContainer = document.getElementById('produtos');
    const categoriasContainer = document.querySelector('article');

    const carregarCategorias = async () => {
        const response = await fetch('../../controllers/produtosController.php?action=listarCategorias');
        const categorias = await response.json();
    
        categoriasContainer.innerHTML = categorias.map(categoria => `
            <div class="category pb-10 relative hover:scale-95 cursor-pointer transition-transform h-28 w-28 rounded-xl items-center border justify-center bg-color-ligth text-sm py-4 text-color-primary font-medium text-center flex flex-col" onclick="selecionarCategoria(${categoria.id}, this)">
                <img class="w-16" src="../../assets/images/products/${categoria.imagem}" alt="${categoria.nome}">
                <h3 class="absolute bottom-3">${categoria.nome}</h3>
            </div>
        `).join('');
    };

    window.selecionarCategoria = (idCategoria, elemento) => {

        const categorias = document.querySelectorAll('.category');
        categorias.forEach(categoria => categoria.classList.remove('bg-color-primary', 'text-color-tertiary'));
    
        elemento.classList.add('bg-color-primary', 'text-color-tertiary');
    
        carregarProdutos(idCategoria);
        
    };

    window.carregarProdutos = async (idCategoria = null) => {
        const endpoint = idCategoria 
            ? `../../controllers/produtosController.php?action=listar&categoria=${idCategoria}`
            : '../../controllers/produtosController.php?action=listar';

        const response = await fetch(endpoint);
        const produtos = await response.json();

        produtosContainer.innerHTML = produtos.map(produto => `
            <div class="product transition-transform h-[240px] p-4 justify-between bg-white rounded-xl border flex flex-col items-center">
                <img src="../../assets/images/${produto.imagem}" class="w-full h-[140px] rounded" alt="${produto.nome}">
                <div class="product-info w-full relative">
                    <h3 class="text-md">${produto.nome}</h3>
                    <h2 class="price text-md font-bold">R$ ${produto.preco}</h2>
                    <button class="button-add-item-to-bag absolute bottom-1 right-0 h-10 w-10 rounded-full bg-color-secondary hover:bg-color-primary text-white transition-all" onclick="adicionarAoCarrinho(${produto.codigo_produto})">
                        <i class='bx bx-shopping-bag text-xl'></i>
                    </button>
                </div>
            </div>
        `).join('');
    };

    const contarItensCarrinho = async () => {
        const response = await fetch('../../controllers/carrinhoController.php?action=contar');
        const total_itens = await response.json();
        document.getElementById('contagemItens').innerHTML = total_itens;
    };

    window.adicionarAoCarrinho = async (codigoProduto) => {
        await fetch('../../controllers/carrinhoController.php?action=adicionar', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ codigo_produto: codigoProduto })
        });
        contarItensCarrinho();
    };

    // Carregar categorias e produtos iniciais
    carregarCategorias();
    carregarProdutos();
    contarItensCarrinho();
});
