@extends('layouts.app')
@section('title', 'Products Detail')
@section('content')
@section('styles')
<section class="section-pagetop bg-dark">
    <div class="container clearfix">
        <h2 style="color: #fff">Products Detail</h2>
    </div>
</section>
<section class="section-content bg padding-y">
    <div class="container">
        <div id="code_prod_complex">
            <div class="row">
                @if(!empty($product))
                    <div class="col-md-6">
                        <figure class="card card-product">
                            <div class="img-wrap padding-y"><img src="https://st1.latestly.com/wp-content/uploads/2021/01/National-Tourism-Day-2021_1.jpg" alt=""></div>
                            <figcaption class="info-wrap">
                                <h4 class="title">{{ $product->name }}</a></h4>
                            </figcaption>
                            <div class="col-md-12">
                                <article class="card mt-4">
                                    <div class="card-body">
                                        {!! $product->description !!}
                                    </div>
                                </article> 
                            </div>
                            <div class="bottom-wrap">
                                @if ($product->price != 0)
                                    <div class="price-wrap h5">
                                    <span class="price pull-right"> {{ config('services.currency_symbol').' : '.$product->price }} </span>
                                    </div>
                                @endif
                            </div>
                        </figure>
                    </div>

                    <div class="col-md-6">
                        <figure class="card card-product">
                            <figcaption class="info-wrap">
                                <h4 class="title">Checkout</a></h4>
                            </figcaption>
                            <div class="col-md-12">
                                <article class="card mt-4">
                                    <div class="card-body">
                                    <form action="{{route('process.payment', [$product, $price])}}" method="POST" id="subscribe-form">
<div class="form-group">
<div class="row">
<div class="col-md-4">
<div class="subscription-option">
<label for="plan-silver">
<span class="plan-price">${{$price}}</span>
</label>
</div>
</div>
</div>
</div>
<label for="card-holder-name">Card Holder Name</label>
<input id="card-holder-name" type="text" value="{{$user->name}}" disabled>
@csrf
<div class="form-row">
<label for="card-element">Credit or debit card</label>
<div id="card-element" class="form-control">   </div>
<!-- Used to display form errors. -->
<div id="card-errors" role="alert"></div>
</div>
<div class="stripe-errors"></div>
@if (count($errors) > 0)
<div class="alert alert-danger">
@foreach ($errors->all() as $error)
{{ $error }}<br>
@endforeach
</div>
@endif
<div class="clear"></div>
<div class="form-group text-center" style="margin-top: 4%;"> <!-- inline css type we can write-->
<button type="button"  id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-lg btn-success btn-block">SUBMIT</button>
</div>
</form>

                                    </div>
                                </article> 
                            </div>
                            <div class="bottom-wrap">
                                
                            </div>
                        </figure>
                    </div>
                @else
                    <p>No Product found.</p>
                @endif
                
            </div>
        </div>
    </div>
</section>
<script src="https://js.stripe.com/v3/"></script>
<script>
var stripe = Stripe('{{ env('STRIPE_KEY') }}');
var elements = stripe.elements();
var style = {
base: {
color: '#32325d',
fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
fontSmoothing: 'antialiased',
fontSize: '16px',
'::placeholder': {
color: '#aab7c4'
}
},
invalid: {
color: '#fa755a',
iconColor: '#fa755a'
}
};
var card = elements.create('card', {hidePostalCode: true, style: style});
card.mount('#card-element');
console.log(document.getElementById('card-element'));
card.addEventListener('change', function(event) {
var displayError = document.getElementById('card-errors');
if (event.error) {
displayError.textContent = event.error.message;
} else {
displayError.textContent = '';
}
});
const cardHolderName = document.getElementById('card-holder-name');
const cardButton = document.getElementById('card-button');
const clientSecret = cardButton.dataset.secret;    cardButton.addEventListener('click', async (e) => {
console.log("attempting");
const { setupIntent, error } = await stripe.confirmCardSetup(
clientSecret, {
payment_method: {
card: card,
billing_details: { name: cardHolderName.value }
}
}
);        if (error) {
var errorElement = document.getElementById('card-errors');
errorElement.textContent = error.message;
}
else {
paymentMethodHandler(setupIntent.payment_method);
}
});
function paymentMethodHandler(payment_method) {
var form = document.getElementById('subscribe-form');
var hiddenInput = document.createElement('input');
hiddenInput.setAttribute('type', 'hidden');
hiddenInput.setAttribute('name', 'payment_method');
hiddenInput.setAttribute('value', payment_method);
form.appendChild(hiddenInput);
form.submit();
}
</script>
</body>
</html>
