<section class="section-payment py-5 my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 bg-white">
                    <h3 class="text-center mb-4 fw-bold text-dark">Thanh Toán Chuyển Khoản Ngân Hàng</h3>
                    
                    <div class="alert alert-info rounded-3 text-center mb-4 py-3" role="alert">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="spinner-border spinner-border-sm text-info me-2" role="status" aria-hidden="true"></span>
                            <span class="fw-bold text-info-dark">Hệ thống đang chờ bạn quét mã chuyển khoản để tự động xác nhận...</span>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-12">
                            {!! $paymentInfoHtml !!}
                        </div>
                    </div>

                    <div class="text-center mt-5 border-top pt-4">
                        <a href="{{ route('public.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            Quay lại trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkStatusUrl = "{{ route('portfolio.package.checkout.check-status', $order->id) }}";
        const successUrl = "{{ route('portfolio.package.checkout.success', $order->id) }}";
        
        let checkInterval = setInterval(function() {
            fetch(checkStatusUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'completed') {
                        clearInterval(checkInterval);
                        window.location.href = successUrl;
                    }
                })
                .catch(error => console.error('Error checking status:', error));
        }, 3000); // Check mỗi 3 giây
    });
</script>
