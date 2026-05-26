'use strict'

$(() => {
    const hasAdminBar = $('.show-admin-bar').length > 0
    const elSelector = '.navbar-sticky',
        element = document.querySelector(elSelector)
    if (!element) return true
    let elHeight = 0,
        elTop = 0,
        dHeight = 0,
        wHeight = 0,
        wScrollCurrent = 0,
        wScrollBefore = 0,
        wScrollDiff = 0
    window.addEventListener('scroll', function () {
        elHeight = element.offsetHeight
        dHeight = document.body.offsetHeight
        wHeight = window.innerHeight
        wScrollCurrent = window.pageYOffset
        wScrollDiff = wScrollBefore - wScrollCurrent
        elTop = parseInt(window.getComputedStyle(element).getPropertyValue('top')) + wScrollDiff
        if (wScrollCurrent <= 0) {
            element.style.top = '0px'
            element.style.position = 'relative'
            $('.navbar').removeClass('navbar-stick')
        } else if (wScrollDiff > 0) {
            element.style.top = (elTop > 0 ? (hasAdminBar ? 40 : 0) : elTop) + 'px'
            element.style.position = 'fixed'
            element.style.width = '100%'
            $('.navbar').addClass('navbar-stick')
        } else if (wScrollDiff < 0) {
            if (wScrollCurrent + wHeight >= dHeight - elHeight)
                element.style.top = ((elTop = wScrollCurrent + wHeight - dHeight) < 0 ? elTop : 0) + 'px'
            else element.style.top = (Math.abs(elTop) > elHeight ? -elHeight : elTop) + 'px'
        }
        wScrollBefore = wScrollCurrent
    })

    $(document)
        .on('click', '.change-price-plan li a', function (e) {
            e.preventDefault()

            $('.change-price-plan li a').removeClass('active')
            $(this).addClass('active')

            const planType = $(this).data('type')

            $('.pricing-plan-item').each(function (index, element) {
                const $priceElement = $(element).find('.text-price-enterprise')
                const $currencyElement = $(element).find('.text-currency-enterprise')
                const $durationElement = $(element).find('.text-duration-enterprise')

                if (planType === 'monthly') {
                    $priceElement.text($priceElement.data('monthly-price'))
                    $currencyElement.text($currencyElement.data('monthly-currency'))
                    $durationElement.text($durationElement.data('monthly-duration'))
                } else if (planType === 'yearly') {
                    $priceElement.text($priceElement.data('annual-price'))
                    $currencyElement.text($currencyElement.data('annual-currency'))
                    $durationElement.text($durationElement.data('annual-duration'))
                }
            })
        })
        .on('submit', 'form.subscribe-form', (e) => {
            e.preventDefault()

            const $form = $(e.currentTarget)
            const $button = $form.find('button[type=submit]')

            $.ajax({
                type: 'POST',
                cache: false,
                url: $form.prop('action'),
                data: new FormData($form[0]),
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $form.find('.alert').remove()
                    $button.prop('disabled', true).addClass('btn-loading')
                },
                success: ({ error, message }) => {
                    if (error) {
                        $form.append(
                            `<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                ${message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                        )
                        return
                    }

                    $form.find('input').val('')

                    $form.append(
                        `<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            ${message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`
                    )

                    document.dispatchEvent(new CustomEvent('newsletter.subscribed'))
                },
                error: (error) => {
                    if (typeof refreshRecaptcha !== 'undefined') {
                        refreshRecaptcha()
                    }

                    $form.append(`
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            ${error.responseJSON.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `)
                },
                complete: () => {
                    if (typeof refreshRecaptcha !== 'undefined') {
                        refreshRecaptcha()
                    }

                    $button.prop('disabled', false).removeClass('btn-loading')
                },
            })
        })
})
