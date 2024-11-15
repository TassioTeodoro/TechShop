async function registrarProduto() {
    const produto = {
        name: document.getElementById('name').value,
        descricao: document.getElementById('descricao').value,
        quantidade: parseInt(document.getElementById('quantidade').value),
        preco: parseFloat(document.getElementById('preco').value),
    };

    try {
        let response = await fetch("http://localhost:8080/src/api/produtos", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(produto),
        });

        if (!response.ok) {
            const errorData = await response.json();
            console.error("Erro:", errorData.message || "Erro desconhecido");
            alert("Erro ao cadastrar produto: " + (errorData.message || "Verifique os dados enviados."));
        } else {
            const data = await response.json();
            console.log("Sucesso:", data.message);
            alert(data.message);
        }
    } catch (error) {
        console.error("Erro de rede:", error);
        alert("Erro de rede. Verifique a conexão.");
    }
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
        name: document.getElementById('name').value,
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
        document.getElementById('name').value = produtoData["name"];
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
