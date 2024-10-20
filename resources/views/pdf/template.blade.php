<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="/img/logo1.ico">
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Imagine Shirt</title>
    @vite('resources/sass/app.scss')
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="resources/sass/app.scss">
    <link rel="stylesheet" href="resources/css/app.css">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>

    <a class="navbar-brand " href="{{ url('/') }}" style="color: blue; text-decoration: none;">
        <?php echo '<img src="',$srcimg,'" width="70" height="50">'; ?>
        <span style="font-size: 30px; font-weight: bold;">Imagine Shirt</span>
    </a>

    <div class="card" style="">
        <div class="card-header bg-dark text-light" style="font-size: 22px; font-weight: bold; ">Order Details</div>
        <div class="card-body" style="font-size: 18px;">
            <div style="float:left; width: 50%">
                <p style="">Order ID: {{ $order->id }}</p>
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

    <div class="card" style="clear:both">
        <div class="card-header bg-dark text-light" style="font-size: 22px; font-weight: bold; ">Client Details</div>
        <div class="card-body" style="font-size: 18px;">

            <p style="">Client Name: {{ $customer->name }}</p>                

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

    <hr>

    <br>
    <h2>Order Items Details</h2>
    <table class="table mt-3" style="width: 100%">
        <thead class="table-dark" style="text-align:left;">
            <tr>
                <th style="text-align:left;">Nome</th>
                <th style="text-align:left;">Tamanho</th>
                <th style="text-align:left;">Cor</th>
                <th style="text-align:left;">Quantidade</th>
                <th style="text-align:left;">Preço Unitário</th>
                <th style="text-align:left;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderItems as $orderItem)
                <tr>
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
    @vite('resources/js/app.js')
</body>
</html>