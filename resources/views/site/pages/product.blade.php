@extends('site.app')
@section('title', $product->name)
@section('pro')

       <!-- Page info -->
	<div class="page-top-info">
		<div class="container">
			<h4>{{ $product->name }}</h4>
			<div class="site-pagination">
				<a href="/">Home</a> /
				
			</div>
		</div>
	</div>
	<!-- Page info end -->

	<!-- product section -->
	<section class="product-section" id="site">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-6">
					<div class="product-pic-zoom">
                    @if ($product->images->count() > 0)
                    <a href="{{ asset('storage/'.$product->images->first()->full) }}" data-fancybox="">
                        <img class="product-big-img" src="{{ asset('storage/'.$product->images->first()->full) }}" alt="">
                    </a>
					</div>
                    @else
                   <div class="img-big-wrap">
                        <div>
                             <a href="https://via.placeholder.com/176" data-fancybox=""><img src="https://via.placeholder.com/176"></a>
                        </div>
                    </div>
                    @endif
				
				@if ($product->images->count() > 0)
				<div class="product-thumbs" tabindex="1" style="overflow: hidden; outline: none;">
				@foreach($product->images as $image)
						<div class="product-thumbs-track">
							<div class="pt" data-imgbigurl="{{ asset('storage/'.$image->full) }}"><img src="{{ asset('storage/'.$image->full) }}" alt=""></div>
						</div>
				@endforeach
					</div>
				@endif
				</div>
				<div class="col-lg-6 product-details">
                    <h2 class="p-title">{{ $product->name }}</h2>
                    @if ($product->sale_price > 0)
                    <h3 class="p-price">
                          
                          <span class="num" id="productPrice">{{ $product->sale_price }}</span>
                          <samll><span class="currency">{{ config('settings.currency_symbol') }}</span></samll>
                           <small><del class="price-old"> {{ $product->price }} {{ config('settings.currency_symbol') }}</del></small>      
                    </h3>
                   
                    @else

					<h3 class="p-price">
                    
                    <span class="num" id="productPrice">{{ $product->price }}</span>
                    <span class="currency">{{ config('settings.currency_symbol') }}</span>
                    </h3>
                    @endif
                    <h3 class="p-stock">
                    <dl class="dlist-inline"> <dt>brand :<span> {{$product->brand->name}}</span></dt></dl>
                    </h3>
                    <br>
                     
                     <div class="p-rating">
                     <h3 class="p-stock"> average rate :: 
                     @for ( $r = 0 ; $r < $product->averageRating ; $r++)
                    <span ><bold><i class="fa fa-star"></i></bold>  </span>
                       
                     @endfor

                    <small>({{ $count }})</small> </h3>
                    </div>

                     
                    @if ($product->quantity > 0)
                    <h3 class="p-stock">Available:
						@if($product->quantity <= 5)
						 <span>In Stock with {{ $product->quantity }} left</span>
						 @else
						 <span>In Stock</span>
						 @endif</h3>
                         @else
                         <h3 class="p-stock">Available: <span>Out of stock</span></h3>
                         @endif
                        
                    <form action="{{ route('product.add.cart') }}" method="POST" role="form" id="addToCart">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <dl class="dlist-inline">
                                                   
                                                    @foreach($attributes as $attribute)
                                                        @php $attributeCheck = in_array($attribute->id, $product->attributes->pluck('attribute_id')->toArray()) @endphp
                                                        
                                                            <tr><td>
                                                        @if ($attributeCheck) 
															<dt>{{ $attribute->name }}: </td></tr></dt>
											
                                                        
                                                            <dd>
                                                                <select class="form-control form-control-sm option" style="width:180px;" name="{{ strtolower($attribute->name ) }}">
                                                                    <option data-price="0" value="0"> Select a {{ $attribute->name }}</option>
                                                                    @foreach($product->attributes as $attributeValue)
                                                                        @if ($attributeValue->attribute_id == $attribute->id)
                                                                            <option
                                                                                data-price="{{ $attributeValue->price }}"
                                                                                value="{{ $attributeValue->value }}"> {{ ucwords($attributeValue->value) }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" name="key" value="{{$attribute->name}}">
															</dd>
															@else
														<dt>            </td></tr></dt>
														
                                                        @endif
                                                    @endforeach
                                                </dl>
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-sm-12">					
					                        	<dl class="dlist-inline">
                                                    <dt>Quantity: </dt>
                                                    <dd>
                                                        <input class="quantity" type="number" min="1" value="1" max="{{ $product->quantity }}" name="qty" style="width:70px;">
                                                        <input type="hidden" name="productImg" value="{{ $product->images->first()->full }}">
                                                        <input type="hidden" name="productId" value="{{ $product->id }}">
                                                        <input type="hidden" name="price" id="finalPrice" value="{{ $product->sale_price != '' ? $product->sale_price : $product->price }}">
                                                    </dd>
                                                </dl>
                                         </div>  </div>
                                        
                    <button type="submit" class="site-btn"><span>ADD TO CART</span></button>
                   
                                        
                    </form>
					<div id="accordion" class="accordion-area">
						<div class="panel">
							<div class="panel-header" id="headingOne">
								<button class="panel-link active" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">Discreption</button>
							</div>
							<div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
								<div class="panel-body">
									<p>{!! $product->description !!}</p>
									
								</div>
							</div>
						</div>
						<div class="panel">
							<div class="panel-header" id="headingThree">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">shipping & Returns</button>
							</div>
							<div id="collapse3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
								<div class="panel-body">
									<p>{!! $product->shipping !!}</p>
								</div>
							</div>
                        </div>
                        
                        

					</div>
					<div class="social-sharing">
						
						<a href="{{ route('admin.settings.insta')}}"><i class="fa fa-instagram"></i></a>
						<a href="{{ route('admin.settings.facebook')}}"><i class="fa fa-facebook"></i></a>
						<a href="{{ route('admin.settings.twitter')}}"><i class="fa fa-twitter"></i></a>
						<a href="{{ route('admin.settings.youtube')}}"><i class="fa fa-youtube"></i></a>
					</div>
				</div>
           
                </div>
                <br><br><br>
                <div class="row">

            @include('site.pages.commentsDisplay', ['comments' => $product->comments, 'product_id' => $product->id])
                </div>
		</div>
            </section>
            
            @stop

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#addToCart').submit(function (e) {
                if ($('.option').val() == 0) {
                    e.preventDefault();
                    alert('Please select an option');
                }
            });
            $('.option').change(function () {
                $('#productPrice').html("{{ $product->sale_price != '' ? $product->sale_price : $product->price }}");
                let extraPrice = $(this).find(':selected').data('price');
                let price = parseFloat($('#productPrice').html());
                let finalPrice = (Number(extraPrice) + price).toFixed(2);
                $('#finalPrice').val(finalPrice);
                $('#productPrice').html(finalPrice);
            });
        });
    </script>

<script type="text/javascript">
    $("#input-id").rating();
</script>








  
<link rel="stylesheet" href="{{asset('rate/style.css')}}">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>





@endpush


