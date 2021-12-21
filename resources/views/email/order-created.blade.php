<div>
    <h2>Your order was created!!</h2>
    <p>These are the details for order # {{$order->id}}</p>
    <table style="width: 600px; text-align: left">
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th style="text-align: center">Quantity</th>
            <th style="text-align: center">Price</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->products as $item)
            <tr>
                <td><img src="{{$item->image}}" alt="{{$item->name}}" width="100px"></td>
                <td>{{$item->name}}</td>
                <td style="text-align: center">{{$item->pivot->quantity}}</td>
                <td style="text-align: center">${{$item->price}}</td>
            </tr>
        @endforeach
        <tr style="font-size: 15px; font-weight: bold; text-align: center">
            <td colspan="2"></td>
            <td>Total:</td>
            <td>${{$order->total}}</td>
        </tr>
        </tbody>
    </table>
</div>
