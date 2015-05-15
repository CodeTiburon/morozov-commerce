@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Checkout</div>
                <div class="panel-body">
                    <div class="checkout">
                        {!! Form::open(array('url' => 'checkout/checkout/make-order','method'=>'POST')) !!}
                        <input id="token" type="hidden" name="_token" value="{{ \MyAuth::tokenEncrypt() }}">
                        <div class="form-group">
                            <p class="customer_info">
                                <strong>1. Customer information</strong>
                            </p>
                            <input id="customer-id" type="hidden" name="customer_id" value="{{ Auth::user()->id }}">
                            <input id="order-status-id" type="hidden" name="order_status_id" value="3">
                            <div class="form-group">
                                {!! Form::label('name','Name:') !!}
                                {!! Form::text('name',  Auth::user()->name , ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('telephone','Telephone:') !!}
                                {!! Form::text('telephone', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="customer_info">
                                <strong>2. Shipping and payment</strong>
                            </p>
                            <div class="form-group">
                                {!! Form::label('shipping-address','Shipping address:') !!}
                                {!! Form::text('shipping_address', null, ['class' => 'form-control', 'id' => 'shipping-address']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('payment-method','Payment method:') !!}
                                {!! Form::text('payment_method', null, ['class' => 'form-control', 'id' => 'payment-method', 'disabled' => 'disabled']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Accept', ['class' => 'btn btn-primary form-control', 'id' => 'checkout-accept']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
