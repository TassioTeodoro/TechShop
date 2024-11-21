async function carregarProdutos() {
    const selectProduto = document.getElementById('produto');
    let produtos = await fetch("http://localhost:8080/src/api/produtos", {
      method: "GET",
    }).then(response => response.json());
  
    let options = "";
    produtos.forEach(produto => {
      options += `<option value="${produto.id}">${produto.name} - R$ ${produto.preco}</option>`
    });
    selectProduto.innerHTML = options;
  }
  
  async function carregarPedidos() {
    const tabelaPedidos = document.getElementById('tabela-pedidos').querySelector('tbody');
    tabelaPedidos.innerHTML = "";
  
    try {
      let pedidos = await fetch("http://localhost:8080/src/api/pedidos", {
        method: "GET",
      }).then(response => response.json());
  
  
      pedidos.forEach(pedido => {
        if (!pedido.name || !pedido.preco || !pedido.quantidade) {
          console.error(`Pedido com dados inválidos: ${JSON.stringify(pedido)}`);
          return;
        }
  
  
        const valorTotal = pedido.quantidade * parseFloat(pedido.preco);
  
        const row = `
          <tr>
            <td>${pedido.name}</td>
            <td>${pedido.quantidade}</td>
            <td>R$ ${parseFloat(pedido.preco).toFixed(2)}</td>
            <td>R$ ${valorTotal.toFixed(2)}</td>
          </tr>
        `;
        tabelaPedidos.innerHTML += row;
      });
    } catch (error) {
      console.error("Erro ao carregar pedidos:", error);
      alert("Erro ao carregar pedidos. Verifique os detalhes no console.");
    }
  }
  
  
  
  async function registrarPedido() {
    const produtoSelect = document.getElementById('produto');
    const pedido = {
      produto_id: parseInt(produtoSelect.value),
      quantidade: parseInt(document.getElementById('quantidade').value),
    };
  
    await fetch("http://localhost:8080/src/api/pedidos", {
      method: "POST",
      body: JSON.stringify(pedido),
      headers: {
        'Content-Type': 'application/json'
      }
    }).then(resp => resp.json());
  
    alert("Pedido cadastrado com sucesso!");
    window.location.reload();
  }
  