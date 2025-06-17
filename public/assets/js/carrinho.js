document.addEventListener('DOMContentLoaded', () => {
    const carrinhoContainer = document.getElementById('carrinho');
    const subtotal = document.getElementById('subtotal');
    const limparCarrinhoBtn = document.getElementById('limparCarrinho');
    const finalizarPedidoBtn = document.getElementById('finalizarPedido');
    const enderecosContainer = document.getElementById('enderecos');

    const carregarCarrinho = async () => {
        const response = await fetch('../../controllers/carrinhoController.php?action=listar');
        const carrinho = await response.json();
    
        console.log(carrinho); // Log para inspecionar os dados retornados
        const total = carrinho.reduce((sum, item) => sum + parseFloat(item.subtotal), 0);
    
        carrinhoContainer.innerHTML = carrinho.map(item => `
            <div class="p-4 border border-gray-200 rounded-lg flex items-center gap-4 bg-white">

                <img src="../../assets/images/${item.imagem}" alt="${item.imagem}" class="h-16 w-16 object-cover rounded">

                <div class="flex-1">
                    <h3 class="font-bold text-xl text-color-primary">${item.nome}</h3>
                    <p class="text-sm font-light text-gray-400">${item.descricao || ''}</p>
                </div>

                <div class="h-10 flex items-center gap-3 border rounded-xl">
                    <button class="text-gray-700 px-3 py-1 rounded transition duration-300" onclick="alterarQuantidade(${item.codigo_item_sacola}, -1)">-</button>
                    <span class="font-bold text-sm">${item.quantidade}</span>
                    <button class="text-gray-700 px-3 py-1 rounded transition duration-300" onclick="alterarQuantidade(${item.codigo_item_sacola}, 1)">+</button>
                </div>
                
                <button class="h-10 border border-primary pt-2 text-primary hover:bg-red-600 hover:text-white px-3 py-1 rounded-xl transition duration-300" onclick="removerItem(${item.codigo_item_sacola})">
                    <i class='bx bx-trash'></i>
                </button>

                <span class="text-xl font-medium ml-6 text-color-primary">R$ <strong>${item.subtotal}</strong></span>

            </div>
        `).join('');
        subtotal.innerHTML = `
            <span class="font-regular">Subtotal:</span>
            <span class="font-bold">R$ ${total.toFixed(2)}</span>
        `;
    };

    const carregarEnderecos = async () => {
        const response = await fetch('../../controllers/carrinhoController.php?action=listarEnderecos');
        const enderecos = await response.json();
    
        enderecosContainer.innerHTML = `
            <label for="enderecos">Selecione o endereço:</label>
            <select id="enderecos" class="border p-2 rounded w-full">
                ${enderecos.map(endereco => `
                    <option value="${endereco.codigo_endereco}">
                        ${endereco.logradouro}, ${endereco.numero}, ${endereco.cidade} - ${endereco.estado}
                    </option>
                `).join('')}
            </select>
        `;
    
        console.log('Endereços carregados:', document.getElementById('enderecosSelect'));
    };

    window.alterarQuantidade = async (codigoItem, quantidade) => {
        console.log(`Alterando item ${codigoItem} com quantidade ${quantidade}`);
        const response = await fetch('../../controllers/carrinhoController.php?action=alterarQuantidade', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ codigo_item: codigoItem, quantidade: quantidade })
        });
    
        if (!response.ok) {
            console.error('Erro ao alterar quantidade:', await response.text());
        }
    
        carregarCarrinho();
    };

    window.removerItem = async (codigoItem) => {
        await fetch(`../../controllers/carrinhoController.php?action=remover&codigo_item=${codigoItem}`, { method: 'POST' });
        carregarCarrinho();
    };

    limparCarrinhoBtn.addEventListener('click', async () => {
        await fetch('../../controllers/carrinhoController.php?action=limpar', { method: 'POST' });
        carregarCarrinho();
    });

    finalizarPedidoBtn.addEventListener('click', async () => {
        const enderecoSelecionado = document.getElementById('enderecos');

        if (!enderecoSelecionado || !enderecoSelecionado.value) {
            Swal.fire({
                title: "Atenção!",
                text: "Selecione um endereço antes de finalizar o pedido.",
                icon: "warning",
                confirmButtonText: "OK",
                confirmButtonColor: "#583C2B",
            });
            return;
        }

        const response = await fetch('../../controllers/carrinhoController.php?action=finalizar', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ codigo_endereco: enderecoSelecionado.value })
        });

        if (response.ok) {
            Swal.fire({
                title: "Sucesso!",
                text: "Pedido Finalizado com Sucesso!",
                icon: "success",
                confirmButtonText: "OK",
                confirmButtonColor: "#583C2B",
            });
            carregarCarrinho();
        } else {
            Swal.fire({
                title: "Erro!",
                text: "Ops! Erro ao finalizar o pedido.",
                icon: "error",
                confirmButtonText: "OK",
                confirmButtonColor: "#583C2B",
            });
        }
    });

    carregarCarrinho();
    carregarEnderecos();
});
