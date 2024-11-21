async function httpRequest(url, method = 'GET', body = null) {
    const options = {
        method,
        headers: { 'Content-Type': 'application/json' },
    };
    if (body) {
        options.body = JSON.stringify(body);
    }

    try {
        const response = await fetch(url, options);
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || "Erro desconhecido");
        }
        return await response.json();
    } catch (error) {
        console.error(`Erro na requisição ${method} ${url}:`, error.message);
        alert(`Erro: ${error.message}`);
        throw error;
    }
}

function getProdutoFormValues() {
    return {
        name: document.getElementById('name').value,
        descricao: document.getElementById('descricao').value,
        quantidade: parseInt(document.getElementById('quantidade').value),
        preco: parseFloat(document.getElementById('preco').value),
    };
}

async function registrarProduto() {
    const produto = {
        name: document.getElementById('name').value,
        descricao: document.getElementById('descricao').value,
        quantidade: parseInt(document.getElementById('quantidade').value, 10),
        preco: parseFloat(document.getElementById('preco').value),
    };

    try {
        const response = await fetch("http://localhost:8080/src/api/produtos", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(produto),
        });

        if (!response.ok) {
            const errorData = await response.json();
            console.error("Erro no registro do produto:", errorData);
            alert("Erro ao cadastrar produto: " + (errorData.message || "Verifique os dados enviados."));
        } else {
            const data = await response.json();
            console.log("Produto cadastrado com sucesso:", data);
            alert(data.message);

            carregarProdutos(); 
        }
    } catch (error) {
        console.error("Erro no registro do produto:", error); 
    }
}


async function carregarProdutos() {
    const produtosLista = document.getElementById("produtos-lista");
    produtosLista.innerHTML = ''; 

    try {
        const response = await fetch("http://localhost:8080/src/api/produtos");

        
        if (!response.ok) throw new Error("Erro ao carregar produtos");

        const produtos = await response.json();

        produtos.forEach(produto => {
            const preco = parseFloat(produto.preco) || 0; 

            const item = document.createElement('div');
            item.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
            item.innerHTML = `
                <strong>${produto.name}</strong>  ${produto.descricao} | R$ ${preco.toFixed(2)}
                <div>
                    <button class="btn btn-warning btn-sm" onclick="window.location.href = 'produtos.html?id=${produto.id}'">Editar</button>
                    <button class="btn btn-danger btn-sm" onclick="removerProduto(${produto.id})">Remover</button>
                </div>
            `;
            produtosLista.appendChild(item);
        });
    } catch (error) {
        console.error("Erro ao carregar produtos:", error);
        alert("Não foi possível carregar a lista de produtos.");
    }
}

function renderProdutosLista(produtos) {
    const produtosLista = document.getElementById("produtos-lista");
    produtosLista.innerHTML = ''; 

    produtos.forEach(produto => {
        const item = document.createElement('div');
        item.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
        item.innerHTML = `
            <strong>${produto.name}</strong> - ${produto.descricao} | R$ ${produto.preco}
            <div>
                <button class="btn btn-warning btn-sm" onclick="editarProduto(${produto.id})">Editar</button>
                <button class="btn btn-danger btn-sm" onclick="removerProduto(${produto.id})">Remover</button>
            </div>
        `;
        produtosLista.appendChild(item);
    });
}

function populateForm(produto) {
    document.getElementById('name').value = produto.name || '';
    document.getElementById('descricao').value = produto.descricao || '';
    document.getElementById('quantidade').value = produto.quantidade || 0;
    document.getElementById('preco').value = produto.preco || 0.0;
}


async function fetchProduto(id) {
    try {
        const response = await fetch(`http://localhost:8080/src/api/produtos?id=${id}`);

        if (!response.ok) {
            throw new Error(`Erro ao buscar produto com ID ${id}`);
        }

        return await response.json();
    } catch (error) {
        console.error("Erro na função fetchProduto:", error);
        alert("Erro ao buscar o produto. Verifique sua conexão.");
        throw error;
    }
}

async function editarProduto() {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    if (!id) {
        return;
    }

    try {
        // Busca o produto pelo ID
        const produto = await fetchProduto(id);

        if (!produto) {
            alert("Produto não encontrado!");
            return;
        }

        // Preenche o formulário com os dados do produto
        populateForm(produto);

        console.log("Produto carregado para edição:", produto);
    } catch (error) {
        console.error("Erro ao carregar produto para edição:", error);
        alert("Erro ao carregar dados do produto. Tente novamente.");
    }
}

async function updateProduto(id) {
    const produto = {
        id: id,
        name: document.getElementById('name').value.trim(),
        descricao: document.getElementById('descricao').value.trim(),
        quantidade: parseInt(document.getElementById('quantidade').value, 10),
        preco: parseFloat(document.getElementById('preco').value),
    };

    if (!produto.name || !produto.descricao || isNaN(produto.quantidade) || isNaN(produto.preco)) {
        alert("Preencha todos os campos corretamente!");
        return;
    }

    try {
        const response = await fetch("http://localhost:8080/src/api/produtos", {
            method: "PUT",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(produto),
        });

        if (!response.ok) {
            const errorData = await response.json();
            console.error("Erro ao atualizar produto:", errorData);
            alert("Erro ao atualizar produto: " + (errorData.message || "Verifique os dados enviados."));
        } else {
            const data = await response.json();
            console.log("Produto atualizado com sucesso:", data);
            alert(data.message);

            window.location.href = "produtos.html"; 
        }
    } catch (error) {
        console.error("Erro ao atualizar produto:", error);
        alert("Erro ao atualizar produto. Verifique sua conexão ou tente novamente.");
    }
}

async function removerProduto(id) {
    if (!confirm("Tem certeza que deseja remover este produto?")) return;

    try {
        await httpRequest("http://localhost:8080/src/api/produtos", "DELETE", { id });
        alert("Produto removido com sucesso!");
        carregarProdutos(); 
    } catch (error) {
        console.error("Erro ao remover produto:", error);
    }
}

function detectType() {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    if (id) {
        updateProduto(id); 
    } else {
        registrarProduto(); 
    }
}