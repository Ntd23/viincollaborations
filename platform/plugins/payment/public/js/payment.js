/**
 * Payment Gateway Toggle & Save JS
 * Cung cấp bởi payment plugin (mock layer)
 * Tương thích với fob-sepay và các gateway khác dùng cùng cấu trúc HTML
 */
$(function () {
    'use strict';

    // -------------------------------------------------
    // 1. Toggle form cài đặt khi nhấn "Cài đặt" / "Chỉnh sửa"
    // -------------------------------------------------
    $(document).on('click', '.toggle-payment-item', function (e) {
        e.preventDefault();
        var $row = $(this).closest('tbody, table').find('.payment-content-item');
        $row.toggleClass('hidden');
    });

    // -------------------------------------------------
    // 2. Kích hoạt / Cập nhật phương thức thanh toán
    // -------------------------------------------------
    $(document).on('click', '.save-payment-item', function (e) {
        e.preventDefault();
        var $btn = $(this);
        var $parentForm = $btn.closest('form');

        if (!$parentForm.length) {
            console.warn('[Payment] Không tìm thấy form cha.');
            return;
        }

        // Lấy giá trị type từ trường hidden trong khu vực nội dung
        var $typeInput = $btn.closest('.payment-content-item, tbody, table').find('input.payment_type');
        var paymentType = $typeInput.val();

        // Xác định trạng thái: save = 1 (kích hoạt/cập nhật)
        var statusKey = paymentType ? ('payment_' + paymentType + '_status') : null;

        if (statusKey) {
            var $existing = $parentForm.find('input[name="' + statusKey + '"]');
            if ($existing.length) {
                $existing.val('1');
            } else {
                $parentForm.append('<input type="hidden" name="' + statusKey + '" value="1">');
            }
        }

        // Đảm bảo field `type` tồn tại trong form cha
        var $existingType = $parentForm.find('input[name="type"]');
        if ($existingType.length) {
            $existingType.val(paymentType || '');
        } else if (paymentType) {
            $parentForm.append('<input type="hidden" name="type" value="' + paymentType + '">');
        }

        $parentForm.submit();
    });

    // -------------------------------------------------
    // 3. Tắt kích hoạt phương thức thanh toán
    // -------------------------------------------------
    $(document).on('click', '.disable-payment-item', function (e) {
        e.preventDefault();

        if (!window.confirm('Bạn có chắc muốn tắt kích hoạt phương thức thanh toán này?')) {
            return;
        }

        var $btn = $(this);
        var $parentForm = $btn.closest('form');

        if (!$parentForm.length) {
            console.warn('[Payment] Không tìm thấy form cha.');
            return;
        }

        var $typeInput = $btn.closest('.payment-content-item, tbody, table').find('input.payment_type');
        var paymentType = $typeInput.val();
        var statusKey = paymentType ? ('payment_' + paymentType + '_status') : null;

        if (statusKey) {
            var $existing = $parentForm.find('input[name="' + statusKey + '"]');
            if ($existing.length) {
                $existing.val('0');
            } else {
                $parentForm.append('<input type="hidden" name="' + statusKey + '" value="0">');
            }
        }

        var $existingType = $parentForm.find('input[name="type"]');
        if ($existingType.length) {
            $existingType.val(paymentType || '');
        } else if (paymentType) {
            $parentForm.append('<input type="hidden" name="type" value="' + paymentType + '">');
        }

        $parentForm.submit();
    });
});
