@extends('template.layout')

@section('main')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-20">
            

            @adminF
                <div class="card" style="float:left; width: 50%;">
                    <div class="card-header bg-dark text-light" style="font-size: 22px;">Order Details
                        <div style="float:right;">
                            @EXCEPTemployee
                                @if($order->status == 'closed' || $order->status == 'paid')
                                    <a href="{{ route('orders.pdf', ['order' => $order]) }}" target="_blank" class="btn btn-secondary">
                                    <i class="fa-regular fa-file"></i></a>
                                @endif
                            @endEXCEPTemployee
                        </div>  
                    </div>
                    <div class="card-body" style="font-size: 20px;">
                        <div style="float:left; width: 50%">
                            <p style="font-weight: bold; ">Order ID: {{ $order->id }}</p>
                            <p style="">Status: 
                                <?php switch($order->status):
                                            case 'pending': ?>
                                                Pending
                                            <?php break; ?>
                                        <?php case 'closed': ?>
                                                Closed
                                            <?php break; ?>
                                        <?php case 'paid': ?>
                                                Paid
                                            <?php break; ?>
                                        <?php case 'canceled': ?>
                                                <span style="color: red; font-weight: bold;">Canceled</span>
                                            <?php break; ?>
                                <?php endswitch; ?>
                            </p>
                        </div>

                        <div style="float:right; width: 50%; text-align:left; content-align:left ">
                            <p style="">Date: {{ $order->date }}</p>
                            <p style="">Total: {{ $order->total_price }} €</p>
                        </div>
                    </div>
                </div>

                <div class="card" style="float:right; width: 50%;">
                    <div class="card-header bg-dark text-light" style="font-size: 22px; padding-top: 14px; text-align:center; content-align: center;">Dashboard</div>
                    <div class="card-body" style="font-size: 20px;  height: 100%;  padding-bottom: 17px; ">
                        <form method="POST" action="{{ route('order.update',  $order) }}">
                            @csrf
                            @method('PATCH')
                            <select class="form-select btn btn-light" name="action" id="orderAction" style="font-size: 20px; background-color:lightgray;">
                                <option value="" selected disabled hidden>Select Action</option>
                                @if($order->status == 'pending')
                                    <option value="paid">Confirm Payment</option>
                                @elseif($order->status == 'paid')
                                    <option value="closed">Close Order</option>
                                @endif
                                @admin
                                    <option value="canceled">Cancel Order</option>
                                @endadmin
                            </select>
                            <button type="submit" class="btn btn-light" style="font-size: 22px ; width: 100%; background-color:lightgray;">Perform Action</button>         
                        </form>
                    </div>
                </div>
            @endadminF

            @customer
                <div class="card" style="">
                    <div class="card-header bg-dark text-light" style="font-size: 22px;">Order Details
                        <div style="float:right;">
                            @if($order->status == 'closed' || $order->status == 'paid')
                                <a href="{{ route('orders.pdf', ['order' => $order]) }}" target="_blank" class="btn btn-secondary">
                                <i class="fa-regular fa-file"></i></a>
                            @endif
                        </div>  
                    </div>
                    <div class="card-body" style="font-size: 20px;">
                        <div style="float:left; width: 50%">
                            <p style="font-weight: bold; ">Order ID: {{ $order->id }}</p>
                            <p style="">Status: 
                                <?php switch($order->status):
                                            case 'pending': ?>
                                                Pending
                                            <?php break; ?>
                                        <?php case 'closed': ?>
                                                Closed
                                            <?php break; ?>
                                        <?php case 'paid': ?>
                                                Paid
                                            <?php break; ?>
                                        <?php case 'canceled': ?>
                                                <p style="color: red; font-weight: bold; margin-top: 0px; margin-top: 0px;">Canceled</p>
                                            <?php break; ?>
                                <?php endswitch; ?>
                            </p>
                        </div>

                        <div style="float:right; width: 50%; text-align:left; content-align:left ">
                            <p style="">Date: {{ $order->date }}</p>
                            <p style="">Total: {{ $order->total_price }} €</p>
                        </div>
                    </div>
                </div>
            @endcustomer

            <br>
    
            <div class="card" style="clear:both">
                <div class="card-header bg-dark text-light" style="font-size: 22px;">Client Details</div>
                <div class="card-body" style="font-size: 20px;">

                    <div style="float:left; width: 50%">
                        <p style="">Client ID: {{ $order->customer_id }}</p>
                        <p style="">Payment Type: {{ $order->payment_type }}</p>
                    </div>

                    <div style="float:right; width: 50%; text-align:left; content-align:left ">
                        <p style="">NIF: {{ $order->nif }}</p>
                    </div>

                    <div style="clear:both">
                        <p style="">Address: {{ $order->address }}</p>
                    </div>

                </div>
            </div>

            <br>

            <div class="card">
                <div class="card-header bg-dark text-light" style="font-size: 22px;">Order Notes</div>
                <div class="card-body" style="font-size: 20px;">
                    <input type="text" name="notes" value="{{ $order->notes }}" style="width: 100%; box-sizing: border-box;" readonly>
                </div>
            </div>

        </div>
    </div>
</div>

<!---->

<br>
<h2>Order Items Details</h2>
<table class="table mt-3">
    <thead class="table-dark">
        <tr>
            <th class="text-center align-middle">Imagem</th>
            <th class="text-center align-middle">Nome</th>
            <th class="text-center align-middle">Tamanho</th>
            <th class="text-center align-middle">Cor</th>
            <th class="text-center align-middle">Quantidade</th>
            <th class="text-center align-middle">Preço Unitário</th>
            <th class="text-center align-middle">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orderItems as $orderItem)
            <tr>
                <td class="text-center align-middle vertical-line">
                <img src="{{ $orderItem['tshirtImage']->fullPhotoUrlPersona }}" alt="Image" width="100" height="100" style="max-width: 100%; height: auto; background-color: gray">

                </td>
                <td class="text-center align-middle vertical-line">
                    <span><strong>{{ $orderItem['tshirtImage']->name }}</strong></span>
                </td>
                <td class="text-center align-middle vertical-line">
                    <span>{{ $orderItem['size'] }}</span>
                </td>
                <td class="text-center align-middle vertical-line">
                    <span>{{ $orderItem['color_code'] }}</span>
                </td>

                <td class="text-center align-middle vertical-line">
                    <span>{{ $orderItem['qty'] }}</span>
                </td>
                <td class="text-center align-middle vertical-line">
                    <span>{{ $orderItem['unit_price'] }}€</span>
                </td>
                </td>
                <td class="text-center align-middle vertical-line">
                    <span style="font-weight: bold;">{{ $orderItem['sub_total'] }}€</span>
                </td>
            </tr>
        @endforeach
            <tr>
                <td colspan="5"> </td>
                <td style="font-weight: bold; text-align: right; font-size: 20px;">Total:</td>
                <td style="font-weight: bold; text-align: center; font-size: 20px;">{{ $order->total_price}} €</td>
            </tr>

    </tbody>    
</table>   

@endsection