@extends('layouts.base')

@section('content')
    <section id="products" class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 fw-bold">Lista de Produtos</h2>
            <div class="input-group" style="width: 300px;">
                <input type="text" id="search" class="form-control" placeholder="Buscar produtos pelo nome">
                <button id="btnSearch" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <!--Tabela dos produtos-->
        <div class="table-responsive">
            <table id="produtosTable" class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </section>

    <section id="add-product" class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">Adicionar/Editar Produto</h2>
        </div>
        <div class="card-body">
            <form id="produtoForm">
                <input type="hidden" id="produtoId">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="descricao">
                    </div>
                    <div class="col-md-4">
                        <label for="preco" class="form-label">Preço (R$)</label>
                        <input type="number" step="0.01" class="form-control" id="preco" required min="0.01"> <!--Deixando o valor mínimo para 0.01 evitando valores negativos-->
                    </div>
                    <div class="col-md-4">
                        <label for="quantidade" class="form-label">Quantidade</label>
                        <input type="number" class="form-control" id="quantidade" required min="1"> <!--Deixando o valor mínimo para 1 para não levar metade sendo apenas inteiro-->
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Salvar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Mensagens para o sistema
    function showAlert(type, message) {
        const alert = $(`
            <div class="alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 1000;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        $('body').append(alert);
        setTimeout(() => alert.alert('close'), 5000);
    }
    //Editar o produto com o novo valro
    function editProduto(id) {
        $.get(`/produtos/${id}`, function(produto) {
            $('#produtoId').val(produto.id);
            $('#nome').val(produto.nome);
            $('#descricao').val(produto.descricao);
            $('#preco').val(produto.preco);
            $('#quantidade').val(produto.quantidade);
        });
    }

    // 
    $(document).ready(function() {
        // Configura automaticamente o token CSRF para todas as requisições do AJAX, evitar ataque CSRF, (Faria de uma forma diferente, por experiencias que tive no governo)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Carregar produtos ao iniciar
        loadProdutos();
        
        // Buscar produtos
        $('#btnSearch').click(searchProdutos); //botão de procurar
        $('#search').keypress(function(e) {
            if (e.which === 13) searchProdutos(); //Procurar através da tecla enter 
        });
        
        // Formulário de salvar
        $('#produtoForm').submit(handleFormSubmit);
    });

    // Procurar produto
    function searchProdutos() {
        const termo = $('#search').val();
        $.get('/produtos/search', { termo }, renderProdutos); // Dentro do controle $produtos = Produto::where('nome', 'like', "%$termo%")->get();
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        
        const produto = {
            nome: $('#nome').val(),
            descricao: $('#descricao').val(),
            preco: parseFloat($('#preco').val()),
            quantidade: parseInt($('#quantidade').val())
        };
        
        const produtoId = $('#produtoId').val();
        const method = produtoId ? 'PUT' : 'POST';
        const url = produtoId ? `/produtos/${produtoId}` : '/produtos';
        
        $.ajax({
            url: url,
            type: method,
            data: produto,
            success: function() {
                showAlert('success', 'Produto salvo com sucesso!');
                loadProdutos();
                $('#produtoForm')[0].reset();
                $('#produtoId').val('');
            },
            error: function(xhr) {
                showAlert('danger', 'Erro ao salvar produto: ' + xhr.responseText);
            }
        });
    }
    //Carregar a lista de produtos via AJAX
    function loadProdutos() {
        $.get('/produtos', renderProdutos)
            .fail(function() {
                showAlert('danger', 'Erro ao carregar produtos');
            });
    }

    function renderProdutos(produtos) {
        const tbody = $('#produtosTable tbody');
        tbody.empty(); //Limpar a tabela

        if (produtos.length === 0) {
            tbody.append('<tr class="no-products"><td colspan="6" class="text-center">Nenhum produto encontrado</td></tr>');
            return;
        } //Caso não tenha produto aparece a mensagem da lista vazia
        produtos.forEach(produto => {
            const preco = parseFloat(produto.preco);//Coneverter o valor para float (Evitar problemas)
            tbody.append(`
                <tr data-id="${produto.id}"> 
                    <td>${produto.id}</td>
                    <td>${produto.nome}</td>
                    <td>${produto.descricao || '-'}</td>
                    <td>R$ ${preco.toFixed(2).replace('.', ',')}</td>
                    <td>${produto.quantidade}</td>
                    <td class="action-buttons">
                        <button class="btn btn-sm btn-warning" onclick="editProduto(${produto.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteProduto(${produto.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }

    //Permitir a exclusão de um produto via AJAX, com uma confirmação de exclusão antes de remover o item. 
    function deleteProduto(id) { 
        if (confirm('Tem certeza que deseja excluir este produto?')) {
            $.ajax({
                url: `/produtos/${id}`,
                type: 'DELETE',
                success: function() {
                    $(`tr[data-id="${id}"]`).remove();
                    showAlert('success', 'Produto excluído com sucesso!');
                    
                    // Verifica se a tabela ficou vazia
                    if ($('#produtosTable tbody tr').not('.no-products').length === 0) {
                        $('#produtosTable tbody').html(
                            '<tr class="no-products"><td colspan="6" class="text-center">Nenhum produto encontrado</td></tr>'
                        );
                    }
                },
                //Caso venha ter algum erro irá mostarr a mensagem
                error: function(xhr) {
                    showAlert('danger', 'Erro ao excluir produto: ' + xhr.responseText);
                }
            });
        }
    }
</script>
@endpush