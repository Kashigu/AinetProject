@extends('template.layout')

@section('titulo', 'Encomendas')

@section('main')

<br>
<div class="container mt-3">
        <form id="filterForm" method="GET" action="{{ route('order.index') }}">
            @csrf
            <div class="row" >
                <div class="col-lg-2">
                    <select class="form-select btn btn-dark" name="estado" id="estadoSelect" style="font-size: 25px">
                        <option value="" selected disabled hidden>Select State</option>
                        <option value="">All</option> 
                        <option {{ $filterByStatus === 'pending' ? 'selected' : '' }} value="pending">Pending</option>
                        <option {{ $filterByStatus === 'paid' ? 'selected' : '' }} value="paid">Paid</option>
                        @EXCEPTemployee
                            <option {{ $filterByStatus === 'closed' ? 'selected' : '' }} value="closed">Closed</option>
                            <option {{ $filterByStatus === 'canceled' ? 'selected' : '' }} value="canceled">Canceled</option>
                        @endEXCEPTemployee
                    </select>
                </div>

                @adminF
                    <div class="col-lg-3">
                        <div class="mb-3 me-2 flex-grow-1 ">
                            <input type="text" class="btn btn-light" style="font-size: 25px ; border: 1px solid black; width: 100% ;" 
                                    placeholder="Nr. da Encomenda" class="form-control" name="numero" id="inputNumero" 
                                    value="{{ $filterByID ?? '' }}">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="mb-3 me-2 flex-grow-1 ">
                            <input type="text" class="btn btn-light" style="font-size: 25px ; border: 1px solid black; width: 100% ;" 
                                placeholder="Nr. Cliente" class="form-control" name="numeroCliente" id="inputNumeroCliente"
                                value="{{ $filterByClientID ?? '' }}">
                        </div>
                    </div>
                @endadminF

                @customer
                    <div class="col-lg-6">
                        <div class="mb-3 me-2 flex-grow-1 ">
                            <input type="text" class="btn btn-light" style="font-size: 25px ; border: 1px solid black; width: 100% ;" 
                                    placeholder="Nr. da Encomenda" class="form-control" name="numero" id="inputNumero" 
                                    value="{{ $filterByID ?? '' }}">
                        </div>
                    </div>
                @endcustomer

                <div class="col-lg-2">
                    <select class="form-select btn btn-dark" name="sort" id="sortSelect" style="font-size: 25px">
                        <option value="" selected disabled hidden>Sort By</option>
                        <option value="">Any</option>
                        <option {{ $sortBy === 'dateOldest' ? 'selected' : '' }} value="dateOldest">Date (Oldest)</option>
                        <option {{ $sortBy === 'dateNewest' ? 'selected' : '' }} value="dateNewest">Date (Newer)</option>
                    </select>
                </div>

                <div class="col-lg-2">
                    <button type="submit" class="btn btn-dark" style="font-size: 25px ; width: 100%">Search <i class="fa-solid fa-magnifying-glass" style="padding-left: 5px"></i></button>
                </div>

            </div>
        </form>

        <br>
        
        <div class="row justify-content-center">

            <table class="table" style="text-align: center;">
                <thead class="table-dark" style="font-size: 18px;">
                    <tr>
                        <th style="width: 12%; text-align: center">Order Number</th>
                        <th>Estado</th>
                        <th>Customer ID</th>
                        <th>Data</th>
                        <th>Preço Total</th>
                        <th class="button-icon-col"> PDF</th>
                        <th class="button-icon-col" style="width: 12%;">Info</th>
                    </tr>
                </thead>
                <tbody style="font-size: 20px;">
                    @foreach($orders as $order)
                    <tr class="table-light" style="content-align: center; text-align:center;">
                        <td style="font-weight: bold;">{{$order->id}}</td>
                        <td style="justify-content: center; align-items: center;">
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
                        </td>
                        <td>{{$order->customer_id}}</td>
                        <td>{{$order->date}}</td>
                        <td>{{$order->total_price}} €</td>

                        @EXCEPTemployee
                            @if($order->status == 'closed' || $order->status == 'paid')
                                <td class="button-icon-col">
                                    <a href="{{ route('orders.pdf', ['order' => $order]) }}" target="_blank" class="btn btn-secondary">
                                    <i class="fa-regular fa-file"></i></a>
                                </td>   
                            @else
                                <td></td>       
                            @endif     
                        @endEXCEPTemployee     

                        @employee
                            <td></td>
                        @endemployee 

                        <td class="button-icon-col">
                            <a href="{{ route('order.show', ['order' => $order]) }}" class="btn btn-secondary">
                            <i class="fa-solid fa-circle-info" style="color: #ffffff;"></i></a>
                        </td>
                    </tr>
                    @endforeach

                    @if($orders->isEmpty())
                        <tr class="table-light" style="content-align: center; text-align:center;">
                            <td colspan="7">Nothing was Found.</td>
                        </tr>
                    @endif
                </tbody>    
            </table>

        </div>

        <div class="mt-3">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>

<script>
    document.getElementById('estadoSelect').addEventListener('change', function () {
        document.getElementById('filterForm').submit();
    });
    document.getElementById('inputNumero').addEventListener('change', function () {
        document.getElementById('filterForm').submit();
    }); 
    document.getElementById('inputNumeroCliente').addEventListener('change', function () {
        document.getElementById('filterForm').submit();
    }); 
    document.getElementById('sortSelect').addEventListener('change', function () {
        document.getElementById('filterForm').submit();
    });    
</script>    

@endsection
