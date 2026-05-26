<section class="section-success py-5 my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 text-center">
                <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 bg-white">
                    <div class="success-icon mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" fill="#d1e7dd" />
                            <path d="M9 12l2 2 4-4" stroke="#0f5132" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>

                    <h3 class="fw-bold text-success mb-2">Thanh Toán Thành Công!</h3>
                    <p class="text-muted mb-4">Cảm ơn bạn đã đăng ký dịch vụ của chúng tôi. Đơn hàng của bạn đã được thanh toán và kích hoạt thành công.</p>

                    <div class="order-details text-start bg-light rounded-3 p-4 mb-4 border">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2">Chi tiết giao dịch</h6>
                        <table class="table table-borderless table-sm mb-0 fs-7">
                            <tbody>
                                <tr>
                                    <td class="text-muted py-1" style="width: 140px;">Gói dịch vụ:</td>
                                    <td class="fw-bold text-dark py-1">{{ $order->package_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-1">Khách hàng:</td>
                                    <td class="fw-bold text-dark py-1">{{ $order->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-1">Email nhận:</td>
                                    <td class="fw-bold text-dark py-1">{{ $order->email }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-1">Số tiền đã trả:</td>
                                    <td class="fw-bold text-success py-1">{{ number_format($order->amount) }} VND</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-1">Mã thanh toán:</td>
                                    <td class="fw-bold text-dark py-1">{{ $order->payment_code }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('public.index') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold hover-up shadow">
                            Quay lại trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
