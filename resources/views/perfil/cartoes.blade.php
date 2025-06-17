@extends('layouts.app')

@section('title', 'Meus Cartões')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-color-secondary mb-8">Meus Cartões</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg border p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-color-secondary">Cartões Cadastrados</h2>
                <span class="text-sm text-gray-500">{{ $cartoes->count() }} cartões</span>
            </div>

            @if($cartoes->count() > 0)
            <div class="space-y-4">
                @foreach($cartoes as $cartao)
                <div
                    class="text-white rounded-xl p-6 shadow-lg relative overflow-hidden
    {{ $cartao->bandeira == 'VISA' ? 'bg-gradient-to-br from-blue-500 to-blue-700' : 'bg-gradient-to-br from-orange-400 to-orange-600' }}">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $cartao->apelido }}</h3>
                            <span class="text-xs bg-white text-blue-700 px-2 py-1 rounded-full">
                                {{ $cartao->tipo }}
                            </span>
                        </div>
                        <div>
                            @if($cartao->bandeira == 'VISA')
                            <img src="{{ asset('images/visa.png') }}" alt="Visa" class="h-8">
                            @else
                            <img src="{{ asset('images/mastercard.png') }}" alt="Mastercard" class="h-8">
                            @endif
                        </div>
                    </div>

                    <div class="mb-6 tracking-widest text-xl">
                        **** **** **** {{ substr($cartao->numero, -4) }}
                    </div>

                    <div class="flex justify-between text-sm">
                        <div>
                            <p class="uppercase text-gray-200">Titular</p>
                            <p class="font-semibold">{{ $cartao->nome_titular }}</p>
                        </div>
                        <div>
                            <p class="uppercase text-gray-200">Validade</p>
                            <p class="font-semibold">{{ $cartao->data_validade_formatada }}</p>
                        </div>
                    </div>

                    <div class="absolute top-2 right-2 flex gap-2">
                        <button onclick="editarCartao({{ $cartao->id }})"
                            class="p-1.5 bg-white/20 hover:bg-white/30 rounded-full transition">
                            <i class='bx bx-edit text-white text-lg'></i>
                        </button>
                        <form action="{{ route('perfil.cartoes.remover', $cartao->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 bg-white/20 hover:bg-white/30 rounded-full transition">
                                <i class='bx bx-trash text-white text-lg'></i>
                            </button>
                        </form>
                    </div>
                </div>

                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <i class='bx bx-credit-card text-5xl text-gray-300 mb-4'></i>
                <p class="text-gray-500">Você não tem cartões cadastrados.</p>
            </div>
            @endif
        </div>

        <div class="bg-white rounded-lg border p-6 h-fit sticky top-4">
            <h2 class="text-xl font-bold text-color-secondary mb-4" id="form-cartao-title">
                <i class='bx bx-credit-card mr-2'></i>
                <span id="form-title-text">Adicionar Cartão</span>
            </h2>

            <form id="cartao-form" method="POST" action="{{ route('perfil.cartoes.adicionar') }}">
                @csrf
                <input type="hidden" name="cartao_id" id="cartao_id">

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Apelido do Cartão</label>
                        <input type="text" name="apelido" class="w-full border rounded-lg px-4 py-2"
                            placeholder="Ex: Cartão principal" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tipo</label>
                            <select name="tipo" class="w-full border rounded-lg px-4 py-2" required>
                                <option value="">Selecione...</option>
                                <option value="Crédito">Crédito</option>
                                <option value="Débito">Débito</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Bandeira</label>
                            <select name="bandeira" class="w-full border rounded-lg px-4 py-2" required>
                                <option value="">Selecione...</option>
                                <option value="VISA">VISA</option>
                                <option value="Mastercard">Mastercard</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nome do Titular</label>
                        <input type="text" name="nome_titular" class="w-full border rounded-lg px-4 py-2"
                            placeholder="Como no cartão" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Número do Cartão</label>
                        <div class="relative">
                            <input type="text" name="numero" id="numero-cartao"
                                class="w-full border rounded-lg px-4 py-2 pl-10" placeholder="0000 0000 0000 0000"
                                maxlength="19" required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class='bx bx-credit-card text-gray-400'></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Validade</label>
                            <input type="text" name="data_validade" id="data-validade"
                                class="w-full border rounded-lg px-4 py-2" placeholder="MM/AAAA" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">CVV</label>
                            <div class="relative">
                                <input type="text" name="cvv" id="cvv" class="w-full border rounded-lg px-4 py-2"
                                    placeholder="123" maxlength="3" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class='bx bx-lock-alt text-gray-400'></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <button type="button" onclick="limparFormularioCartao()"
                            class="text-gray-500 hover:text-gray-700 px-4 py-2">
                            <i class='bx bx-x mr-1'></i> Cancelar
                        </button>
                        <button type="submit" id="submit-button"
                            class="bg-color-primary text-white px-6 py-2 rounded-lg hover:bg-opacity-90 flex items-center">
                            <i class='bx bx-save mr-1'></i>
                            <span>Salvar Cartão</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function editarCartao(id) {
    fetch(`/perfil/cartoes/editar/${id}`)
        .then(response => {
            if (!response.ok) throw new Error('Erro ao carregar cartão');
            return response.json();
        })
        .then(data => {
            document.getElementById('form-title-text').textContent = 'Editar Cartão';
            document.getElementById('cartao_id').value = data.id;

            document.querySelector('input[name="apelido"]').value = data.apelido;
            document.querySelector('select[name="tipo"]').value = data.tipo;
            document.querySelector('select[name="bandeira"]').value = data.bandeira;
            document.querySelector('input[name="nome_titular"]').value = data.nome_titular;
            document.querySelector('input[name="numero"]').value = data.numero;
            document.querySelector('input[name="data_validade"]').value = data.data_validade;
            document.querySelector('input[name="cvv"]').value = data.cvv;

            const form = document.getElementById('cartao-form');
            form.action = `/perfil/cartoes/editar/${id}`;

            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            form.scrollIntoView({
                behavior: 'smooth'
            });
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Não foi possível carregar os dados do cartão');
        });
}

function limparFormularioCartao() {
    document.getElementById('form-title-text').textContent = 'Adicionar Cartão';
    document.getElementById('cartao-form').reset();
    document.getElementById('cartao_id').value = '';

    const form = document.getElementById('cartao-form');
    form.action = '{{ route("perfil.cartoes.adicionar") }}';

    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) {
        methodInput.remove();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const numeroCartao = document.getElementById('numero-cartao');
    if (numeroCartao) {
        numeroCartao.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            this.value = value.slice(0, 19);
        });
    }

    const dataValidade = document.getElementById('data-validade');
    if (dataValidade) {
        dataValidade.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 6);
            }
            this.value = value;
        });
    }

    const cvv = document.getElementById('cvv');
    if (cvv) {
        cvv.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 3);
        });
    }

    const form = document.getElementById('cartao-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitButton = document.getElementById('submit-button');
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="bx bx-loader-alt animate-spin mr-1"></i> Salvando...';
        });
    }
});
</script>
@endpush
@endsection