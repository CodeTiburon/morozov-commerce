<div class="minicart">
    @if($mini_cart['cart_count'] != 0)
        <div class="minicart-count">
            <strong>Total products: </strong><span class="badge">{{ $mini_cart['cart_count'] }}</span>
        </div>
        <div class="minicart-price">
            <strong>Total sum: </strong><span>{{ $mini_cart['cart_price'] }}</span> $.
        </div>
        <div class="minicart-button">
            <a href="{{ url('checkout/cart') }}" class="btn btn-warning"><span class="glyphicon glyphicon-shopping-cart"></span> Cart open</a>
        </div>
    @else
        <p>The cart is empty </p>
    @endif
</div>