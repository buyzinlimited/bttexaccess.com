<div style="background-color: #fff">
    <h2>Product Inquiry</h2>
    <div style="margin-bottom: 30px">
        <p>Name: {{ $name }}</p>
        <p>Phone: {{ $phone }}</p>
        <p>Email: {{ $email }}</p>
        <p>Location: {{ $location }}</p>
    </div>
    <div>
        <h3>Products</h3>
        @foreach($products as $product)
            <div>
                <h3>{{ $loop->index + 1 }}.  {{ $product['title'] }}</h3>
                <p>Category: {{ $product['category']['name'] }}</p>
                <p>Brand: {{ $product['brand']['name'] }}</p>
                <p>Quantity: {{ $product['quantity'] }}</p>
            </div>
        @endforeach
    </div>
</div>
