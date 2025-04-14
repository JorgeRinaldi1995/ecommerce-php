<h1>Produtos</h1>
<ul>
    <?php foreach ($products as $product): ?>
        <li>
            <?= $product['name'] ?> - R$<?= $product['price'] ?>
            <form method="POST" action="/cart/add" style="display:inline;">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <button type="submit">Adicionar ao Carrinho</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
<a href="/cart">Ver carrinho</a>
