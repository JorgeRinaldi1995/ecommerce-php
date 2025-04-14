<h1>Carrinho de Compras</h1>

<?php $cart = $_SESSION['cart'] ?? []; ?>

<?php if (empty($cart)): ?>
    <p>Seu carrinho está vazio.</p>
<?php else: ?>
    <ul>
        <?php $total = 0; ?>
        <?php foreach ($cart as $id => $item): ?>
            <?php $subtotal = $item['price'] * $item['quantity']; ?>
            <li>
                <?= $item['product'] ?> - R$<?= number_format($item['price'], 2) ?>
                (<?= $item['quantity'] ?> un)
                - Subtotal: R$<?= number_format($subtotal, 2) ?>

                <form method="POST" action="/cart/remove" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?= $id ?>">
                    <button type="submit">Remover</button>
                </form>
            </li>
            <?php $total += $subtotal; ?>
        <?php endforeach; ?>
    </ul>

    <h3>Total: R$<?= number_format($total, 2) ?></h3>
    <a href="/cart/checkout">Finalizar compra</a>
<?php endif; ?>

<br><br>
<a href="/">Voltar para produtos</a>
