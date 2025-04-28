let token = $('meta[name="csrf-token"]').attr('content');

    $(function() {
        $(".addcart").on('click',function (e) {
			e.preventDefault();
			var elemento = e.target;
            var id = this.getAttribute('data-id');  
		
            
            Swal.fire({
                header: '...',
                title: 'loading...',
                allowOutsideClick:false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: "add",
                method: "post",
                dataType: 'json',
                data: {
                    _token: token,
                    id: id
                },
                success: function (response) {   
                    if (response.status) {
						document.getElementById('cartCount').innerText = response.count;
						
                        const Toast = Swal.mixin({
						toast: true,
						position: "top-start",
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
							toast.onmouseenter = Swal.stopTimer;
							toast.onmouseleave = Swal.resumeTimer;
						}
						});
						Toast.fire({
						icon: "success",
						title: response.msg
						});               
                    } else {
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
						icon: "error",
						title: "Algo salió mal"
						});
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