<script type="text/template" id="product-template">
    <div class="product">
        <h3><a class="link-to-product" href="{{ url('products/show/').'/' }}<%= id %>"><%= name %></a></h3>
        <p><%= model %></p>
        <p>
            <a class="link-to-product" href="{{ url('products/show/').'/' }}<%= id %>">
                <img style="max-width:200px" src="<%= image %>" alt="<%= name %>"/>
            </a>
        </p>
        <br/>
        <p class="description"><%= description %> </p>
        <br/>
        <div class="price">
            Price: <%= price %> $
        </div>
        <br/>
        <a data-id="<%= id %>" href="#" class="btn btn-success add-to-cart"><span class="glyphicon glyphicon-shopping-cart"></span> Add to cart</a>
    </div>
</script>
