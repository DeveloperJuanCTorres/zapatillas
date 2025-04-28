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
                            <li class="nav-item active"><a class="nav-link" href="/tienda">Tienda</a></li>
							
							<li class="nav-item"><a class="nav-link" href="/contact">Contáctanos</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Login</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item">
								<a href="{{route('cart')}}" class="cart">
									<span class="ti-bag"></span>
									<span class="badge bg-danger" id="cartCount" style="line-height: 15px !important;margin-bottom: 10px; display: table-caption;height: 20px;width: 20px; border-radius: 20px;color: white;">{{\Cart::count()}}</span></a></li>
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
					<h1>Tienda</h1>
					<nav class="d-flex align-items-center">
						<a href="/">Inicio<span class="lnr lnr-arrow-right"></span></a>
						<a href="#">Tienda</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<div class="container py-5">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<form id="filterForm">
					<div class="sidebar-categories">
						<div class="head">Filtro por Categorías</div>
						<ul class="main-categories">
							@foreach($categories as $key => $category)
							<ul>
								<li class="filter-list">
									<input class="pixel-radio" type="radio" name="categories[]" value="{{ $category->id }}">									
									<label for="{{$category->name}}">{{$category->name}}
										<span>({{$category->products->count()}})</span>
									</label>
								</li>
							</ul>
							@endforeach
						</ul>
					</div>
					<div class="sidebar-filter mt-50">
						<div class="top-filter-head">Filtro por Productos</div>
						<div class="common-filter">
							<div class="head">Marcas</div>
							<form action="#">
								<ul>								
									@foreach($brands as $key => $brand)
									<li class="filter-list">
										<input class="pixel-radio" type="radio" name="brands[]" value="{{ $brand->id }}">
										<label for="{{$brand->name}}">{{$brand->name}}
											<span>({{$brand->products->count()}})</span>
										</label>
									</li>
									@endforeach
								</ul>
							</form>
						</div>
						<div class="common-filter">
							<div class="head">Color</div>
							<form action="#">
								<ul>
									@foreach($colors as $key => $color)
									<li class="filter-list">
										<input class="pixel-radio" type="radio" name="colors[]" value="{{ $color->id }}">
										<label for="{{$color->name}}">{{$color->name}}
											<span>({{$color->products->count()}})</span>
										</label>
									</li>
									@endforeach
								</ul>
							</form>
						</div>
					</div>
				</form>
			</div>

			<!-- PRODUCT LIST -->
			<div class="col-xl-9 col-lg-8 col-md-7">   
				 <!-- Spinner oculto al principio -->
				<div id="loadingSpinner" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 z-10">
					<div class="w-12 h-12 border-4 border-blue-500 border-dashed rounded-full animate-spin"></div>
				</div>

				<section class="lattest-product-area pb-40 category-list" id="productContainer">
					@include('product-list')
				</section>				
    		<!-- END PRODUCT LIST -->
			</div>
		</div>
	</div>

    @include('footer')

	@push('scripts')
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="js/addcart.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
		const form = document.getElementById('filterForm');
		const productContainer = document.getElementById('productContainer');
		const loadingSpinner = document.getElementById('loadingSpinner');

		form.addEventListener('change', function () {
			fetchProducts();
		});

		function fetchProducts(page = 1) {
			const formData = new FormData(form);
			const params = new URLSearchParams(formData);

			loadingSpinner.classList.remove('hidden'); // Mostrar spinner

			fetch(`{{ route('tienda.products') }}?${params.toString()}&page=${page}`, {
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				}
			})
			.then(response => response.text())
			.then(html => {
				productContainer.innerHTML = html;
			})
			.finally(() => {
				loadingSpinner.classList.add('hidden'); // Ocultar spinner
			});
		}

		// Paginación AJAX
		document.addEventListener('click', function(e) {
			if (e.target.closest('.pagination a')) {
				e.preventDefault();
				const url = new URL(e.target.href);
				const page = url.searchParams.get('page');
				fetchProducts(page);
			}
		});
	});
	</script>
	@endpush

@endsection