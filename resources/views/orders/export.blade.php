<table>
    <thead>
        <tr>
            <th style="font-size:16px;width: 200px;font-weight:bolder">Address</th>
            <th style="font-size:16px;width: 150px;font-weight:bolder">Full Name </th>
            <th style="font-size:16px;width: 100px;font-weight:bolder">Total</th>
            <th style="font-size:16px;width: 150px;font-weight:bolder">Shipping</th>
            <th style="font-size:16px;width: 100px;font-weight:bolder">Payment</th>
            <th style="font-size:16px;width: 150px;font-weight:bolder">Status</th>
            <th style="font-size:16px;width: 150px;font-weight:bolder">Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->address }}</td>
                <td>{{ $order->user->full_name }}</td>
                <td>${{ $order->total }}</td>
                <td>{{ $order->shipping->shipping_name }}</td>
                <td>{{ $order->userPayment->payment->payment_name }}</td>
                <td>
                        @if ($order->status ==0)
                            Cancelled
                        @elseif($order->status ==1)
                        Awaiting Payment
                        @elseif($order->status ==2)
                        Waiting Confirmation
                        @elseif($order->status ==3)
                        Preparing
                        @elseif($order->status ==4)
                        Being Transported
                        @elseif($order->status ==5)
                         Delivered successfully
                        @endif

                </td>
                <td>{{ $order->created_at }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
