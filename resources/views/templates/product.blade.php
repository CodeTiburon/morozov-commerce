<script type="text/template" id="product-template">
    <div class="product">
        <h3><a class="link-to-product" href="{{ url('products/show/').'/' }}<%= id %>"><%= name %></a></h3>
        <p><%= model %></p>
        <p>
            <a class="link-to-product" href="{{ url('products/show/').'/' }}<%= id %>">
                <img style="max-width:200px" src="<%= image %>" alt="<%= name %>"/>
            </a>
        </p>
        <p class="description"><%= description %> </p>
    </div>
</script>
