@extends('layouts.app')

@section('content')
    <!-- Start Header Area -->
    <header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="/"><img src="{{asset('img/logo3.png')}}" width="60" alt=""></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav menu_nav ml-auto">
							<li class="nav-item"><a class="nav-link" href="/">Inicio</a></li>
                            <li class="nav-item"><a class="nav-link" href="/tienda">Tienda</a></li>
							<li class="nav-item"><a class="nav-link" href="/contact">Contactanos</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Login</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item">
								<a href="{{route('cart')}}" class="cart">
									<span class="ti-bag"></span>
									<span class="badge bg-danger" style="line-height: 15px !important;margin-bottom: 10px; display: table-caption;height: 20px;width: 20px; border-radius: 20px;color: white;">{{\Cart::count()}}</span></a></li>
							<li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between">
					<input type="text" class="form-control" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>
	</header>
	<!-- End Header Area -->

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Checkout</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="single-product.html">Checkout</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">        
            <div class="billing_details">
                
                    <div class="row">                    
                        <div class="col-lg-8">
                            <h3>Detalles de facturación</h3>                        
                                <div class="col-md-6 form-group p_star">
                                    <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Nombre">
                                </div>
                                <div class="col-md-6 form-group p_star">
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" required placeholder="Apellidos">
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" id="company" name="company" placeholder="Nombre de empresa">
                                </div>
                                <div class="col-md-6 form-group p_star">
                                    @include('phone')
                                </div>
                                <div class="col-md-6 form-group p_star">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="direccion" name="direccion" required placeholder="Dirección">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="city" name="city">
                                    <span class="placeholder" data-placeholder="Town/City"></span>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <select class="country_select">
                                        <option value="1">District</option>
                                        <option value="2">District</option>
                                        <option value="4">District</option>
                                    </select>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="creat_account">
                                        <h3>Shipping Details</h3>
                                        <input type="checkbox" id="f-option3" name="selector">
                                        <label for="f-option3">Enviar a una dirección diferente?</label>
                                    </div>
                                    <textarea class="form-control" name="mensaje" id="mensaje" rows="1" placeholder="Escribir mensaje."></textarea>
                                </div>                            
                        </div>
                        <div class="col-lg-4">
                            <div class="order_box">
                                <h2>Detalle de pedido</h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th style="width: 30px;">Qty</th>
                                            <th class="text-center" style="width: 100px;">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Cart::content() as $item)
                                        <tr>
                                            <td>{{$item->name}}</td>
                                            <td>x {{$item->qty}}</td>
                                            <td class="text-center">S/. {{number_format($item->qty * $item->price,2)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                <ul class="list list_2">
                                    <li><a href="#">Subtotal <span>S/. {{number_format(Cart::subtotal() - Cart::subtotal()*18/100,2)}}</span></a></li>
                                    <li><a href="#">IGV (18%) <span>S/. {{number_format(Cart::subtotal()*18/100,2)}}</span></a></li>
                                    <li><a href="#" style="font-size: 20px;">Total <span>S/. {{number_format(Cart::subtotal(),2)}}</span></a></li>
                                </ul>
                                <!-- <div class="payment_item py-4">
                                    <h2>Métodos de pago</h2>
                                    <div class="radion_btn">
                                        <input type="radio" id="f-option5" name="selector">
                                        <label for="f-option5">Yape (978 209 130)</label>
                                    </div>
                                    <img class="d-block m-auto" src="img/qr.png" alt="">
                                </div>
                                <div class="payment_item active">
                                    <div class="radion_btn">
                                        <input type="radio" id="f-option6" name="selector">
                                        <label for="f-option6">Plin (978 209 130)</label>
                                    </div>
                                    <img class="d-block m-auto" src="img/qr.png" alt="">                          
                                </div>
                                <div class="creat_account">
                                    <input type="checkbox" id="f-option4" name="selector">
                                    <label for="f-option4">He leído y acepto los </label>
                                    <a href="#">terminos & condiciones*</a>
                                </div> -->
                                <button type="submit" class="primary-btn w-100 pedido">Enviar pedido</button>
                            </div>
                        </div>                        
                    </div>
                
            </div>
        </div>
    </section>
    <!--================End Checkout Area =================-->

    @include('footer')

    @push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    let token = $('meta[name="csrf-token"]').attr('content');

    $(function() {
        $(".pedido").on('click',function () {
            var nombre = $("#nombre").val();
            var apellidos = $("#apellidos").val();
            var empresa = $("#company").val();
            var codigo = $("#codigo").val();
            var telefono = $("#telefono").val();
            var email = $("#email").val();
            var direccion = $("#direccion").val();
            var hoy = new Date();   
                                
            
            if (nombre == '') {
                const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
                });
                Toast.fire({
                icon: "warning",
                title: "El nombre es requerido"
                });
                $('#nombre').focus();
                return false;
            }
            if (apellidos == '') {
                const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
                });
                Toast.fire({
                icon: "warning",
                title: "El apellido es requerido"
                });
                $('#apellidos').focus();
                return false;
            }
            if (telefono == '') {
                const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
                });
                Toast.fire({
                icon: "warning",
                title: "El teléfono es requerido"
                });
                $('#telefono').focus();
                return false;
            }
            if (direccion == '') {
                const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
                });
                Toast.fire({
                icon: "warning",
                title: "La dirección es requerido"
                });
                $('#direccion').focus();
                return false;
            }

            Swal.fire({
                header: '...',
                title: 'loading...',
                allowOutsideClick:false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: "/enviar_pedido",
                method: "post",
                dataType: 'json',
                data: {
                    _token: token,
                    nombre: nombre,
                    apellidos : apellidos,
                    empresa : empresa,
                    codigo : codigo,
                    telefono: telefono,
                    email: email,
                    direccion: direccion
                },
                success: function (response) {   
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pedido',
                            text: response.msg,   
                            confirmButtonColor: "#e75e8d",                           
                        })
                        .then(resultado => {
                            window.location.href = "/";
                        })                 
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ups, algo salio mal',
                            text: response.msg,
                            confirmButtonColor: "#e75e8d",
                        })
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...!!',
                        text: 'Algo salió mal, Inténtalo más tarde!',
                    })
                }
            });
        });
    })
    </script>
    @endpush
    @endsection

    