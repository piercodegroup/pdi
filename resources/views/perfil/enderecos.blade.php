@extends('layouts.app')

@section('title', 'Meus Endereços')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-color-secondary mb-8">Meus Endereços</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg border p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-color-secondary">Endereços Cadastrados</h2>
                <span class="text-sm text-gray-500">{{ $enderecos->count() }} endereços</span>
            </div>

            @if($enderecos->count() > 0)
            <div class="space-y-4">
                @foreach($enderecos as $endereco)
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-semibold capitalize">{{ strtolower($endereco->tipo) }}</h3>
                                @if($endereco->tipo == 'Residencial')
                                <i class='bx bx-home text-blue-500'></i>
                                @else
                                <i class='bx bx-building text-green-500'></i>
                                @endif
                            </div>
                            <p class="text-gray-700">{{ $endereco->logradouro }}, {{ $endereco->numero }}</p>
                            @if($endereco->complemento)
                            <p class="text-sm text-gray-600">Complemento: {{ $endereco->complemento }}</p>
                            @endif
                            <p class="text-gray-700">{{ $endereco->bairro }}</p>
                            <p class="text-gray-700">{{ $endereco->cidade }}/{{ $endereco->estado }}</p>
                            <p class="text-gray-700">CEP: {{ $endereco->cep }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="editarEndereco({{ $endereco->id }})"
                                class="p-2 text-blue-500 hover:bg-blue-50 rounded-full transition">
                                <i class='bx bx-edit text-xl'></i>
                            </button>
                            <form action="{{ route('perfil.enderecos.remover', $endereco->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-full transition">
                                    <i class='bx bx-trash text-xl'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <i class='bx bx-map text-5xl text-gray-300 mb-4'></i>
                <p class="text-gray-500">Você não tem endereços cadastrados.</p>
                <p class="text-sm text-gray-400 mt-2">Adicione um endereço para receber seus pedidos</p>
            </div>
            @endif
        </div>

        <div class="bg-white rounded-lg border p-6 h-fit sticky top-4">
            <h2 class="text-xl font-bold text-color-secondary mb-4" id="form-endereco-title">
                <i class='bx bx-map mr-2'></i>
                <span id="form-title-text">Adicionar Endereço</span>
            </h2>

            <form id="endereco-form" method="POST" action="{{ route('perfil.enderecos.adicionar') }}">
                @csrf
                <input type="hidden" name="endereco_id" id="endereco_id">

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Tipo de Endereço</label>
                        <select name="tipo" class="w-full border rounded-lg px-4 py-2" required>
                            <option value="">Selecione...</option>
                            <option value="Residencial">Residencial</option>
                            <option value="Comercial">Comercial</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Logradouro</label>
                            <input type="text" name="logradouro" class="w-full border rounded-lg px-4 py-2"
                                placeholder="Rua, Avenida, etc." required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Número</label>
                            <input type="text" name="numero" class="w-full border rounded-lg px-4 py-2" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Complemento</label>
                        <input type="text" name="complemento" class="w-full border rounded-lg px-4 py-2"
                            placeholder="Apto, Bloco, etc.">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Bairro</label>
                        <input type="text" name="bairro" class="w-full border rounded-lg px-4 py-2" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Cidade</label>
                            <input type="text" name="cidade" class="w-full border rounded-lg px-4 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Estado</label>
                            <input type="text" name="estado" class="w-full border rounded-lg px-4 py-2" placeholder="UF"
                                maxlength="2" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">CEP</label>
                        <div class="relative">
                            <input type="text" name="cep" id="cep" class="w-full border rounded-lg px-4 py-2 pl-10"
                                placeholder="00000-000" required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class='bx bx-map-pin text-gray-400'></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <button type="button" onclick="limparFormulario()"
                            class="text-gray-500 hover:text-gray-700 px-4 py-2">
                            <i class='bx bx-x mr-1'></i> Cancelar
                        </button>
                        <button type="submit" id="submit-button"
                            class="bg-color-primary text-white px-6 py-2 rounded-lg hover:bg-opacity-90 flex items-center">
                            <i class='bx bx-save mr-1'></i>
                            <span>Salvar Endereço</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function editarEndereco(id) {
    fetch(`/perfil/enderecos/${id}/editar`)
        .then(response => {
            if (!response.ok) throw new Error('Erro ao carregar endereço');
            return response.json();
        })
        .then(data => {
            document.getElementById('form-title-text').textContent = 'Editar Endereço';
            document.getElementById('endereco_id').value = data.id;

            document.querySelector('select[name="tipo"]').value = data.tipo;
            document.querySelector('input[name="logradouro"]').value = data.logradouro;
            document.querySelector('input[name="numero"]').value = data.numero;
            document.querySelector('input[name="complemento"]').value = data.complemento || '';
            document.querySelector('input[name="bairro"]').value = data.bairro;
            document.querySelector('input[name="cidade"]').value = data.cidade;
            document.querySelector('input[name="estado"]').value = data.estado;
            document.querySelector('input[name="cep"]').value = data.cep;

            const form = document.getElementById('endereco-form');
            form.action = `/perfil/enderecos/${id}/editar`;

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
            alert('Não foi possível carregar os dados do endereço');
        });
}

function limparFormulario() {
    document.getElementById('form-title-text').textContent = 'Adicionar Endereço';
    document.getElementById('endereco-form').reset();
    document.getElementById('endereco_id').value = '';

    const form = document.getElementById('endereco-form');
    form.action = '{{ route("perfil.enderecos.adicionar") }}';

    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) {
        methodInput.remove();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        cepInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.slice(0, 5) + '-' + value.slice(5, 8);
            }
            this.value = value.slice(0, 9);
        });
    }

    const form = document.getElementById('endereco-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitButton = document.getElementById('submit-button');
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="bx bx-loader-alt animate-spin mr-1"></i> Salvando...';
        });
    }

    if (cepInput) {
        cepInput.addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.querySelector('input[name="logradouro"]').value = data
                                .logradouro || '';
                            document.querySelector('input[name="bairro"]').value = data.bairro ||
                                '';
                            document.querySelector('input[name="cidade"]').value = data
                                .localidade || '';
                            document.querySelector('input[name="estado"]').value = data.uf || '';
                        }
                    });
            }
        });
    }
});
</script>
@endpush
@endsection