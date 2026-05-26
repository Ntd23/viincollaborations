<section class="section-checkout py-5 my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 bg-white">
                    <h3 class="text-center mb-4 fw-bold">Thông Tin Thanh Toán</h3>
                    <div class="package-details bg-light rounded-3 p-4 mb-4 border">
                        <h5 class="mb-1 text-primary fw-bold">{{ $package->name }}</h5>
                        <p class="mb-0 text-muted fs-7">{!! BaseHelper::clean($package->description) !!}</p>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Giá Gói:</span>
                            <span class="fs-4 fw-bold text-success">{{ $package->price }} VND</span>
                        </div>
                    </div>

                    <form action="{{ route('portfolio.package.checkout.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3 py-2" id="name" name="name" required placeholder="Nhập họ và tên của bạn" value="{{ old('name') }}">
                            @error('name') <span class="text-danger fs-7">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Địa chỉ Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control rounded-3 py-2" id="email" name="email" required placeholder="example@gmail.com" value="{{ old('email') }}">
                            @error('email') <span class="text-danger fs-7">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Phương thức thanh toán <span class="text-danger">*</span></label>
                            <div class="payment-methods-list">
                                @if(empty($paymentMethodsHtml))
                                    <div class="alert alert-warning py-2 fs-7">Hệ thống hiện chưa cấu hình cổng thanh toán nào. Vui lòng quay lại sau!</div>
                                @else
                                    {!! $paymentMethodsHtml !!}
                                @endif
                            </div>
                            @error('payment_method') <span class="text-danger fs-7">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow hover-up" @if(empty($paymentMethodsHtml)) disabled @endif>
                            Tiếp Tục Thanh Toán
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
