<table>
    <thead>
        <tr>
            <th style="font-size:16px;width: 250px;font-weight:bolder">Product Name</th>
            <th style="font-size:16px;width: 100px;font-weight:bolder">Price</th>
            <th style="font-size:16px;width: 100px;font-weight:bolder">Category</th>
            <th style="font-size:16px;width: 200px;font-weight:bolder">Product Description</th>
            <th style="font-size:16px;width: 200px;font-weight:bolder">Created At</th>

        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->product_name }}</td>
                <td>${{ $product->price }}</td>
                <td>{{ $product->category->category_name }}</td>
                <td>{{   substr($product->product_description, 0, 20)}}...</td>
                <td>{{ $product->created_at }}</td>


            </tr>
        @endforeach
    </tbody>
</table>
