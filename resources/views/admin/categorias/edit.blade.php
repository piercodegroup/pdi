@extends('layouts.admin')

@section('title', 'Editar Categoria')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Editar Categoria: {{ $categoria->nome }}</h1>
        <a href="{{ route('admin.categorias.index') }}" 
           class="px-5 py-2 rounded-full border-gray-400 border hover:bg-gray-700 hover:text-white hover:border-gray-700">
            Voltar
        </a>
    </div>

    <form action="{{ route('admin.categorias.update', $categoria->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-lg border p-6 mb-6">
            <h2 class="text-lg font-medium mb-4">Informações da Categoria</h2>
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome da Categoria</label>
                    <input type="text" name="nome" value="{{ $categoria->nome }}" 
                           class="w-full rounded border-gray-300 border p-2" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                    <textarea name="descricao" rows="3" 
                              class="w-full rounded border-gray-300 border p-2">{{ $categoria->descricao }}</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Imagem Atual</label>
                    <div class="border-2 border-gray-200 rounded-lg p-4">
                        <img src="{{ asset($categoria->imagem) }}" alt="{{ $categoria->nome }}" 
                             class="h-32 mx-auto object-cover rounded">
                    </div>
                    
                    <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">Alterar Imagem</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <input type="file" name="imagem" id="imagem" 
                               class="hidden" accept="image/*"
                               onchange="previewImage(this)">
                        <label for="imagem" class="cursor-pointer">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-1 text-sm text-gray-600">Clique para selecionar uma nova imagem</p>
                            <p class="text-xs text-gray-500 mt-1">Formatos: jpeg, png, jpg, gif (max: 2MB)</p>
                        </label>
                        <div id="image-preview" class="mt-2 hidden">
                            <img id="preview" class="h-32 mx-auto" src="#" alt="Pré-visualização da nova imagem">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-right">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Atualizar Categoria
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const imagePreview = document.getElementById('image-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection