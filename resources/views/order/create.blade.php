@extends('template.layout')

@section('titulo', 'Payment')

@section('main')

<br>

<form id="formStore" method="POST" action="{{ route('order.store') }}">
    @csrf
    <div class="card" style="clear:both">
        <div class="card-header bg-dark text-light" style="font-size: 22px;">Payment Details</div>
        <div class="card-body" style="font-size: 20px;">

            <div style="">
                NIF:
                <input type="text" name="nif" value="{{$userNIF}}" id="nif" style="" maxlength="9"> 
                @error('nif')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <br>

            <div style="">
                Address: 
                <input type="text" name="address" value="{{$userAddress}}" id="address" style="width: 50%">   
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror    
            </div>

            <br>

            <div class="col-lg-2">
                <select class="form-select btn btn-light" name="payment_type" id="paymentSelect" style="font-size: 20px; background-color:lightgray;">
                    <option value="" selected disabled hidden>Select Payment Type</option>
                    <option value="VISA" {{ $userDefaultPT == 'VISA' ? 'selected' : '' }} >VISA</option>
                    <option value="MC" {{ $userDefaultPT == 'MC' ? 'selected' : '' }} >Master Card</option>
                    <option value="PAYPAL" {{ $userDefaultPT == 'PAYPAL' ? 'selected' : '' }} >PAYPAL</option>
                </select>  
                @error('paymentSelect')
                    <span class="text-danger">{{ $message }}</span>
                @enderror   
            </div>  

            <br>

            <div style="">
                Payment Reference: 
                <input type="text" name="payment_ref" value="{{$userDefaultPR}}" style="width: 30%">  
                @error('payment_ref')
                    <span class="text-danger">{{ $message }}</span>
                @enderror   
            </div>

        </div>
    </div>

    <br>

    <div class="card" style="clear:both">
        <div class="card-header bg-dark text-light" style="font-size: 22px;">Adicional Details</div>
        <div class="card-body" style="font-size: 20px;">

            <div style="">
                Notes:
                <input type="text" name="notes" value="" style="width: 100%; box-sizing: border-box;">       
            </div>

        </div>
    </div>

    <div class="my-4 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="ok" form="formStore">Finalizar Compra</button>
    </div>

</form>


@endsection