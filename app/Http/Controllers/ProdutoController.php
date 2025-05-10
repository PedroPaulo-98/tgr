<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto; //Chamando a model PRODUTO


class ProdutoController extends Controller
{
    public function index() // O Index será a página principal e irá listar todos os produtos
    {
        return response()->json(Produto::all()); // Puxar todos os produtos (::all())
    }
    public function search(Request $request) // O search irei pesquisar um produto
    {
        $termo = $request->input('termo');
        $produtos = Produto::where('nome', 'like', "%$termo%")->get();
        return response()->json($produtos);
    }
    public function show($id) // O show irá mostrar um produto específico
    {
        return response()->json(Produto::findOrFail($id));
    }
    public function store(Request $request)// O store irei criar um produto
    {
        $validated = $request->validate([
            'nome' => 'required|string', //deixando o nome como obrigatório
            'descricao' => 'nullable|string|max:100', //Descricao podendo ser vazia e deixando no máximo 100
            'preco' => 'required|numeric|min:0.01',// Preço como obrigatório e no mínimo 0.01
            'quantidade' => 'required|integer|min:1'//quantidade sendo o minimo 1
        ]);

        $produto = Produto::create($validated);
        return response()->json(['message' => 'Produto criado com sucesso!','data' => $produto], 201);    }
    public function update(Request $request, $id) //Update para atualizar o produto
    {
        $validated = $request->validate([
            'nome' => 'sometimes|string',
            'descricao' => 'nullable|string|max:100',
            'preco' => 'sometimes|numeric|min:0.01',
            'quantidade' => 'sometimes|integer|min:1'
        ]);

        $produto = Produto::findOrFail($id);
        $produto->update($validated);
        return response()->json(['message' => 'Produto excluído com sucesso!']);
    }
        public function destroy($id)//Apagar o produto
    {
        Produto::findOrFail($id)->delete();
        return response()->json(['message' => 'Produto excluído com sucesso!'])->cookie('Produto Apagado com Sucesso!');
    }
}
