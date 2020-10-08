<h1>Product kina hoice </h1>
<table class="table">
  <thead>
    <tr>
      <th>Sl. No</th>
      <th>Product Name</th>
      <th>Product Quantity</th>
      <th>Product price</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($order_details as $order_detail)
      <tr>
        <td>{{ $loop->index +1 }}</td>
        <td>{{ $order_detail->product->product_name }}</td>
        <td>{{ $order_detail->product_quantity}}</td>
        <td>{{ $order_detail->product_price}}</td>
      </tr>
    @endforeach
  </tbody>
</table>
<div>
  {{-- @foreach ($orders as $order) --}}
      <p>Sub Total:{{ $orders->sub_total }}</p>
      <p>Discount Amount:{{ $orders->discount_amount }}</p>
      <p>Total:{{ $orders->total }}</p>
  {{-- @endforeach --}}
</div>