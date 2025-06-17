@extends('layouts.admin')

@section('title', 'Criar Novo Pedido')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Criar Novo Pedido</h1>
        <a href="{{ route('admin.pedidos.index') }}" 
           class="px-5 py-2 rounded-full border-gray-400 border hover:bg-gray-700 hover:text-white hover:border-gray-700">
            Voltar
        </a>
    </div>

    <form action="{{ route('admin.pedidos.store') }}" method="POST">
        @csrf
        
        <div class="bg-white rounded-lg border p-6 mb-6">
            <h2 class="text-lg font-medium mb-4">Informações Básicas</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                    <select name="cliente_id" id="cliente_id" 
                            class="w-full rounded border-gray-300 border p-2" required
                            onchange="carregarEnderecosECartoes(this.value)">
                        <option value="">Selecione um cliente</option>
                        @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nome }} ({{ $cliente->email }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Método de Pagamento</label>
                    <select name="metodo_pagamento_id" id="metodo_pagamento_id" 
                            class="w-full rounded border-gray-300 border p-2" required
                            onchange="toggleCartaoField(this.value)">
                        <option value="">Selecione um método</option>
                        @foreach($metodosPagamento as $metodo)
                        <option value="{{ $metodo->id }}">{{ $metodo->nome }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div id="endereco_field">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Endereço de Entrega</label>
                    <select name="endereco_id" id="endereco_id" 
                            class="w-full rounded border-gray-300 border p-2" required disabled>
                        <option value="">Selecione um cliente primeiro</option>
                    </select>
                </div>
                
                <div id="cartao_field" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cartão</label>
                    <select name="cartao_id" id="cartao_id" 
                            class="w-full rounded border-gray-300 border p-2">
                        <option value="">Selecione um cartão</option>
                    </select>
                </div>
                
                <div id="troco_field" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Troco para</label>
                    <input type="number" name="troco" id="troco" step="0.01" min="0"
                           class="w-full rounded border-gray-300 border p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" 
                            class="w-full rounded border-gray-300 border p-2" required>
                        <option value="">Selecione um Status</option>
                        <option value="Recebido">Recebido</option>
                        <option value="Em preparo">Em preparo</option>
                        <option value="A caminho">A caminho</option>
                        <option value="Entregue">Entregue</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                    </select>
                </div>

            </div>
        </div>
        
        <div class="bg-white rounded-lg border p-6 mb-6">
            <h2 class="text-lg font-medium mb-4">Produtos</h2>
            
            <div id="produtos_container">
                <div class="grid grid-cols-12 gap-4 mb-2 font-medium text-gray-500 text-sm">
                    <div class="col-span-5">Produto</div>
                    <div class="col-span-3">Quantidade</div>
                    <div class="col-span-3">Preço Unitário</div>
                    <div class="col-span-1"></div>
                </div>
                
                <div class="produto-item mb-4 grid grid-cols-12 gap-4 items-center">
                    <div class="col-span-5">
                        <select name="produtos[0][id]" class="produto-select w-full rounded border-gray-300 border p-2" required
                                onchange="atualizarPreco(this)">
                            <option value="">Selecione um produto</option>
                            @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}" 
                                    data-preco="{{ number_format($produto->preco, 2, '.', '') }}">
                                {{ $produto->nome }} (Estoque: {{ $produto->estoque }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-3">
                        <input type="number" name="produtos[0][quantidade]" min="1" value="1" 
                               class="quantidade w-full rounded border-gray-300 border p-2" required
                               onchange="calcularSubtotal(this)">
                    </div>
                    <div class="col-span-3">
                        <span class="preco-unitario">R$ 0,00</span>
                        <input type="hidden" class="preco-unitario-input" value="0">
                    </div>
                    <div class="col-span-1">
                        <button type="button" class="remover-produto text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <button type="button" id="adicionar_produto" 
                    class="mt-4 px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                Adicionar Produto
            </button>
        </div>
        
        <div class="bg-white rounded-lg border p-6 mb-6">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-medium">Total</h2>
                <div class="text-2xl font-bold" id="total_pedido">R$ 0,00</div>
            </div>
        </div>
        
        <div class="text-right">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Criar Pedido
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    let produtoCount = 1;
    const produtosContainer = document.getElementById('produtos_container');
    const primeiroItem = document.querySelector('.produto-item');
    const form = document.querySelector('form');

    document.getElementById('adicionar_produto').addEventListener('click', function() {
        const newItem = primeiroItem.cloneNode(true);
        const newIndex = produtoCount++;
        
        newItem.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace('[0]', `[${newIndex}]`);
            el.value = '';
        });
        
        newItem.querySelector('.preco-unitario').textContent = 'R$ 0,00';
        newItem.querySelector('.preco-unitario-input').value = '0';
        newItem.querySelector('.quantidade').value = '1';
        
        produtosContainer.appendChild(newItem);
        console.log('Produto adicionado', newIndex);
    });

    produtosContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remover-produto')) {
            const items = document.querySelectorAll('.produto-item');
            if (items.length > 1) {
                e.target.closest('.produto-item').remove();
                calcularTotal();
                console.log('Produto removido');
            }
        }
    });

    window.carregarEnderecosECartoes = function(clienteId) {
        console.log('Carregando endereços e cartões para cliente:', clienteId);
        if (!clienteId) return;
        
        const enderecoSelect = document.getElementById('endereco_id');
        enderecoSelect.disabled = false;
        enderecoSelect.innerHTML = '<option value="">Carregando...</option>';
        
        fetch(`/admin/clientes/${clienteId}/enderecos`)
            .then(response => {
                if (!response.ok) throw new Error('Erro ao carregar endereços');
                return response.json();
            })
            .then(data => {
                console.log('Endereços carregados:', data);
                enderecoSelect.innerHTML = data.length 
                    ? data.map(endereco => 
                        `<option value="${endereco.id}">
                            ${endereco.logradouro}, ${endereco.numero} - ${endereco.bairro}
                        </option>`
                      ).join('')
                    : '<option value="">Nenhum endereço cadastrado</option>';
            })
            .catch(error => {
                console.error('Erro:', error);
                enderecoSelect.innerHTML = '<option value="">Erro ao carregar</option>';
            });

        fetch(`/admin/clientes/${clienteId}/cartoes`)
            .then(response => {
                if (!response.ok) throw new Error('Erro ao carregar cartões');
                return response.json();
            })
            .then(data => {
                console.log('Cartões carregados:', data);
                const cartaoSelect = document.getElementById('cartao_id');
                cartaoSelect.innerHTML = data.length 
                    ? data.map(cartao => 
                        `<option value="${cartao.id}">
                            ${cartao.nome_titular} - **** **** **** ${cartao.numero.slice(-4)}
                        </option>`
                      ).join('')
                    : '<option value="">Nenhum cartão cadastrado</option>';
            })
            .catch(error => {
                console.error('Erro:', error);
                document.getElementById('cartao_id').innerHTML = '<option value="">Erro ao carregar</option>';
            });
    };

    window.toggleCartaoField = function(metodoPagamentoId) {
        console.log('Método de pagamento selecionado:', metodoPagamentoId);
        const cartaoField = document.getElementById('cartao_field');
        const trocoField = document.getElementById('troco_field');
        
        cartaoField.style.display = metodoPagamentoId === '1' ? 'block' : 'none';
        trocoField.style.display = metodoPagamentoId === '2' ? 'block' : 'none';
        
        if (metodoPagamentoId === '1') {
            document.getElementById('cartao_id').required = true;
            document.getElementById('troco').required = false;
        } else if (metodoPagamentoId === '2') {
            document.getElementById('cartao_id').required = false;
            document.getElementById('troco').required = true;
        } else {
            document.getElementById('cartao_id').required = false;
            document.getElementById('troco').required = false;
        }
    };

    window.atualizarPreco = function(select) {
        const option = select.options[select.selectedIndex];
        const preco = option.getAttribute('data-preco') || '0';
        const container = select.closest('.produto-item');
        
        container.querySelector('.preco-unitario').textContent = 
            'R$ ' + parseFloat(preco).toLocaleString('pt-BR', {minimumFractionDigits: 2});
        container.querySelector('.preco-unitario-input').value = preco;
        
        calcularSubtotal(select);
    };

    window.calcularSubtotal = function(input) {
        const container = input.closest('.produto-item');
        const preco = parseFloat(container.querySelector('.preco-unitario-input').value) || 0;
        const quantidade = parseInt(input.value) || 0;
        
        if (preco && quantidade) {
            const subtotal = preco * quantidade;
        }
        
        calcularTotal();
    };

    window.calcularTotal = function() {
        let total = 0;
        
        document.querySelectorAll('.produto-item').forEach(item => {
            const preco = parseFloat(item.querySelector('.preco-unitario-input').value) || 0;
            const quantidade = parseInt(item.querySelector('.quantidade').value) || 0;
            
            total += preco * quantidade;
        });
        
        document.getElementById('total_pedido').textContent = 
            'R$ ' + total.toLocaleString('pt-BR', {minimumFractionDigits: 2});
    };

    form.addEventListener('submit', function(e) {
        console.log('Tentativa de envio do formulário');
        
        if (!document.getElementById('endereco_id').value) {
            e.preventDefault();
            alert('Selecione um endereço de entrega');
            return;
        }
        
        const metodoPagamento = document.getElementById('metodo_pagamento_id').value;
        if (metodoPagamento === '1' && !document.getElementById('cartao_id').value) {
            e.preventDefault();
            alert('Selecione um cartão para pagamento');
            return;
        }
        
        if (metodoPagamento === '2' && !document.getElementById('troco').value) {
            e.preventDefault();
            alert('Informe o valor para troco');
            return;
        }
        
        let hasProducts = false;
        document.querySelectorAll('.produto-select').forEach(select => {
            if (select.value) hasProducts = true;
        });
        
        if (!hasProducts) {
            e.preventDefault();
            alert('Adicione pelo menos um produto ao pedido');
            return;
        }
        
        console.log('Formulário validado com sucesso');
    });

    console.log('Inicialização completa');
    calcularTotal();
});
</script>
@endpush
@endsection