    <div class="mb-8 flex justify-end py-4">
        {{ $products->links('vendor.pagination.bootstrap-5') }}
    </div>

    <div class="row">
        <!-- single product -->
         @forelse($products as $product)
        <div class="col-lg-4 col-md-6">
            <div class="single-product">
                @php
                    $imagenes = json_decode($product->images)
                @endphp
                @if($imagenes)
                <img class="img-fluid" src="storage/{{$imagenes[0]}}" alt="">
                @else
                <img class="img-fluid" src="img/defecto.jpg" alt="">
                @endif
                <div class="product-details">
                    <h6>{{$product->name}}</h6>
                    <div class="price">
                        <h6>S/. {{$product->price}}</h6>
                        <h6 class="l-through">S/. {{$product->price + $product->price*10/100}}</h6>
                    </div>
                    <div class="prd-bottom">

                        <a href="#" class="social-info addcart" data-id="{{$product->id}}">
                            <span class="ti-bag"></span>
                            <p class="hover-text" >Agregar</p>	
                        </a>
                        <a href="" class="social-info">
                            <span class="lnr lnr-heart"></span>
                            <p class="hover-text">Wishlist</p>
                        </a>
                        <a href="" class="social-info">
                            <span class="lnr lnr-sync"></span>
                            <p class="hover-text">compare</p>
                        </a>
                        <a href="" class="social-info">
                            <span class="lnr lnr-move"></span>
                            <p class="hover-text">view more</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <p>No hay productos que coincidan con tu búsqueda.</p>
        @endforelse
        <!-- single product -->
    </div>

 
    <div class="mb-8 flex justify-end">
        {{ $products->links('vendor.pagination.bootstrap-5') }}
    </div>
