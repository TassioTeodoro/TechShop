async function carregarProdutos() {
  const selectProduto = document.getElementById('produto');
  let produtos = await fetch("http://localhost:8080/src/api/produtos", {
      method: "GET",
  }).then(response => response.json());

  produtos.forEach(produto => {
      const option = document.createElement('option');
      option.value = produto.id;
      option.text = `${produto.nome} - R$${produto.preco}`;
      selectProduto.add(option);
  });
}

async function registrarPedido() {
  const pedido = {
      produto_id: document.getElementById('produto').value,
      quantidade: document.getElementById('quantidade').value,
  };

  await fetch("http://localhost:8080/src/api/pedidos", {
      method: "POST",
      body: JSON.stringify(pedido),
      headers: {
          'Content-Type': 'application/json'
      }
  }).then(resp => resp.text());
  alert("Pedido cadastrado com sucesso!");
  window.location.reload();
}

carregarProdutos();
