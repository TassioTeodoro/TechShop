async function registrarProduto() {
    const produto = {
        nome: document.getElementById('nome').value,
        descricao: document.getElementById('descricao').value,
        quantidade: document.getElementById('quantidade').value,
        preco: document.getElementById('preco').value,
    };
    await fetch("http://localhost:8080/src/api/produtos", {
        method: "POST",
        body: JSON.stringify(produto),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(resp => resp.text());
}

async function fetchProduto(id) {
    let produto = await fetch(`http://localhost:8080/src/api/produtos?id=${id}`, {
        method: "GET",
    }).then(response => response.json());
    return produto;
}

async function updateProduto(id) {
    const produto = {
        id: id,
        nome: document.getElementById('nome').value,
        descricao: document.getElementById('descricao').value,
        quantidade: document.getElementById('quantidade').value,
        preco: document.getElementById('preco').value,
    };
    await fetch("http://localhost:8080/src/api/produtos", {
        method: "PUT",
        body: JSON.stringify(produto),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(resp => resp.text());
}

async function onUpdate() {
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size !== 0) {
        let id = parseInt(fromGet.get("id"));
        let produtoData = await fetchProduto(id);
        document.getElementById('nome').value = produtoData["nome"];
        document.getElementById('descricao').value = produtoData["descricao"];
        document.getElementById('quantidade').value = produtoData["quantidade"];
        document.getElementById('preco').value = produtoData["preco"];
    }
}

function detectType() {
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size !== 0) {
        updateProduto(fromGet.get("id"));
    } else {
        registrarProduto();
    }
}

onUpdate();
