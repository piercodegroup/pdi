<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\Cartao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function index()
    {
        $cliente = Auth::guard('cliente')->user();
        return view('perfil.index', compact('cliente'));
    }

    public function atualizar(Request $request)
    {
        $cliente = Auth::guard('cliente')->user();
        
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes,email,'.$cliente->id,
            'telefone' => 'nullable|string|max:20',
            'senha_atual' => 'nullable|string',
            'nova_senha' => 'nullable|string|min:8|confirmed',
        ]);

        $cliente->nome = $request->nome;
        $cliente->email = $request->email;
        $cliente->telefone = $request->telefone;

        if ($request->nova_senha) {
            if (!Hash::check($request->senha_atual, $cliente->senha)) {
                return back()->withErrors(['senha_atual' => 'Senha atual incorreta']);
            }
            $cliente->senha = Hash::make($request->nova_senha);
        }

        $cliente->save();

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }

    public function enderecos()
    {
        $enderecos = Auth::guard('cliente')->user()->enderecos;
        return view('perfil.enderecos', compact('enderecos'));
    }

    public function adicionarEndereco(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:Residencial,Comercial',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:10',
        ]);

        Auth::guard('cliente')->user()->enderecos()->create($request->all());

        return back()->with('success', 'Endereço adicionado com sucesso!');
    }

    public function editarEndereco(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:Residencial,Comercial',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:10',
        ]);

        $endereco = Endereco::where('cliente_id', Auth::guard('cliente')->id())
                           ->findOrFail($id);
        $endereco->update($request->all());

        return back()->with('success', 'Endereço atualizado com sucesso!');
    }

    public function removerEndereco($id)
    {
        $endereco = Endereco::where('cliente_id', Auth::guard('cliente')->id())
                           ->findOrFail($id);
        $endereco->delete();

        return back()->with('success', 'Endereço removido com sucesso!');
    }











    

    public function cartoes()
    {
        $cartoes = Auth::guard('cliente')->user()->cartoes;
        return view('perfil.cartoes', compact('cartoes'));
    }

    public function adicionarCartao(Request $request)
    {
        \Log::debug('Dados recebidos:', $request->all());

        $request->merge([
            'numero' => str_replace(' ', '', $request->numero)
        ]);

        $validated = $request->validate([
            'tipo' => 'required|in:Crédito,Débito',
            'apelido' => 'required|string|max:255',
            'nome_titular' => 'required|string|max:255',
            'bandeira' => 'required|in:VISA,Mastercard',
            'numero' => 'required|string|size:16|regex:/^[0-9]{16}$/',
            'data_validade' => ['required', 'regex:/^(0[1-9]|1[0-2])\/[0-9]{4}$/'],
            'cvv' => 'required|string|size:3|regex:/^[0-9]{3}$/',
        ]);

        list($mes, $ano) = explode('/', $validated['data_validade']);
        $dataValidade = \Carbon\Carbon::createFromDate($ano, $mes, 1)->endOfMonth();
        
        \Log::debug('Data validade processada:', ['raw' => $validated['data_validade'], 'processed' => $dataValidade]);

        if ($dataValidade->lt(now())) {
            return back()->withErrors(['data_validade' => 'O cartão está vencido.']);
        }

        try {
            $dadosCartao = [
                'tipo' => $validated['tipo'],
                'apelido' => $validated['apelido'],
                'nome_titular' => $validated['nome_titular'],
                'bandeira' => $validated['bandeira'],
                'numero' => $validated['numero'],
                'data_validade' => $dataValidade,
                'cvv' => $validated['cvv']
            ];

            $cartao = Auth::guard('cliente')->user()->cartoes()->create($dadosCartao);
            
            \Log::debug('Cartão criado com sucesso:', ['id' => $cartao->id]);
            
            return back()->with('success', 'Cartão adicionado com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao criar cartão:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Erro ao salvar cartão. Por favor, tente novamente.']);
        }
    }

    public function getCartaoParaEdicao($id)
    {
        $cartao = Cartao::where('cliente_id', Auth::guard('cliente')->id())
                    ->findOrFail($id);
        
        return response()->json([
            'id' => $cartao->id,
            'apelido' => $cartao->apelido,
            'tipo' => $cartao->tipo,
            'bandeira' => $cartao->bandeira,
            'nome_titular' => $cartao->nome_titular,
            'numero' => $cartao->numero,
            'data_validade' => $cartao->data_validade->format('m/Y'),
            'cvv' => $cartao->cvv
        ]);
    }

    public function editarCartao(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:Crédito,Débito',
            'apelido' => 'required|string|max:255',
            'nome_titular' => 'required|string|max:255',
            'bandeira' => 'required|in:VISA,Mastercard',
            'numero' => 'required|string|size:16',
            'data_validade' => ['required', 'regex:/^(0[1-9]|1[0-2])\/[0-9]{4}$/'],
            'cvv' => 'required|string|size:3',
        ]);
        
        try {
            list($mes, $ano) = explode('/', $request->data_validade);
            $dataValidade = \Carbon\Carbon::createFromDate($ano, $mes, 1)->endOfMonth();
            
            if ($dataValidade->lt(now())) {
                return back()->withErrors(['data_validade' => 'O cartão está vencido.']);
            }

            $cartao = Cartao::where('cliente_id', Auth::guard('cliente')->id())
                        ->findOrFail($id);
            
            $dadosCartao = $request->except(['data_validade', '_method', '_token']);
            $dadosCartao['data_validade'] = $dataValidade;
            
            $cartao->update($dadosCartao);

            return back()->with('success', 'Cartão atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao atualizar cartão: ' . $e->getMessage()]);
        }
    }

    public function removerCartao($id)
    {
        $cartao = Cartao::where('cliente_id', Auth::guard('cliente')->id())
                       ->findOrFail($id);
        $cartao->delete();

        return back()->with('success', 'Cartão removido com sucesso!');
    }
}