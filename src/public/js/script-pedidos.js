document.addEventListener("DOMContentLoaded", () => {
    fetchProdutos();
});

function fetchProdutos() {
    fetch('http://localhost:8080/api/produtos') // ajuste o caminho conforme sua configuração
        .then(response => response.json())
        .then(data => {
            const produtosLista = document.getElementById("produtos-lista");
            produtosLista.innerHTML = ""; // Limpa a lista antes de adicionar os produtos
            data.forEach(produto => {
                const produtoItem = document.createElement("div");
                produtoItem.className = "produto-item";
                
                produtoItem.innerHTML = `
                    <span>${produto.nome} - R$${produto.preco.toFixed(2)}</span>
                    <input type="number" min="1" value="1" id="quantidade-${produto.id}">
                    <button onclick="comprarProduto(${produto.id})">Comprar</button>
                `;
                
                produtosLista.appendChild(produtoItem);
            });
        })
        .catch(error => console.error("Erro ao carregar produtos:", error));
}

function comprarProduto(produtoId) {
    const quantidade = document.getElementById(`quantidade-${produtoId}`).value;
    fetch(`http://localhost:8080/api/pedidos`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            produto_id: produtoId,
            quantidade: parseInt(quantidade)
        })
    })
    .then(response => response.json())
    .then(data => {
        alert(`Pedido realizado com sucesso! Pedido ID: ${data.id}`);
        // Aqui você pode adicionar lógica para atualizar a lista ou exibir o pedido
    })
    .catch(error => console.error("Erro ao realizar pedido:", error));
}
