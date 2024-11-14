const apiUrl = 'http://localhost:8080/src/api/produtos'; 

// Função para listar todos os produtos
async function fetchProducts() {
    const response = await fetch(apiUrl);
    const products = await response.json();

    const productList = document.getElementById('product-list');
    productList.innerHTML = '';

    products.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td>${product.description}</td>
            <td>R$ ${product.price.toFixed(2)}</td>
            <td>
                <button onclick="editProduct(${product.id})">Editar</button>
                <button class="delete" onclick="deleteProduct(${product.id})">Excluir</button>
            </td>
        `;
        productList.appendChild(row);
    });
}

// Função para criar ou atualizar um produto
async function saveProduct(event) {
    event.preventDefault();

    const id = document.getElementById('product-id').value;
    const name = document.getElementById('name').value;
    const description = document.getElementById('description').value;
    const price = parseFloat(document.getElementById('price').value);

    const product = { name, description, price };

    if (id) {
        // Atualizar produto existente
        await fetch(`${apiUrl}/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(product)
        });
    } else {
        // Criar novo produto
        await fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(product)
        });
    }

    clearForm();
    fetchProducts();
}

// Função para carregar dados do produto no formulário para edição
async function editProduct(id) {
    const response = await fetch(`${apiUrl}/${id}`);
    const product = await response.json();

    document.getElementById('product-id').value = product.id;
    document.getElementById('name').value = product.name;
    document.getElementById('description').value = product.description;
    document.getElementById('price').value = product.price;
}

// Função para excluir um produto
async function deleteProduct(id) {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
        await fetch(`${apiUrl}/${id}`, { method: 'DELETE' });
        fetchProducts();
    }
}

// Função para limpar o formulário
function clearForm() {
    document.getElementById('product-form').reset();
    document.getElementById('product-id').value = '';
}

// Inicializar a lista de produtos e configurar o formulário
document.getElementById('product-form').addEventListener('submit', saveProduct);
fetchProducts();
