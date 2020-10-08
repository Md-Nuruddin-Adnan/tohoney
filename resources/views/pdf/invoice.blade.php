<h1>This is a pdf file</h1>

<ul>
  <li>Order ID: #{{ $order_info->id }}</li>
  <li>Sub Total: {{ $order_info->sub_total }}</li>
  @if ($order_info->coupon_name == '-')
  <li>No discount</li>
  @else
    <li>Coupon Name: {{ $order_info->coupon_name }}</li>
    <li>Discount Amount: {{ $order_info->discount_amount }}</li>
  @endif
  <li>Total: {{ $order_info->total }}</li>
</ul>