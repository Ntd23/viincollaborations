<div class="bg-neutral-100 p-5 mt-5 rounded-4 border quotation-form-widget"
    @style(["background-color: $backgroundColor !important" => $backgroundColor])
>
    @if ($title = Arr::get($config, 'title'))
        <strong class="d-block fs-6 mb-4">{!! BaseHelper::clean($title) !!}</strong>
    @endif

    <div class="row mt-5">
        {!! $form->renderForm() !!}
    </div>
</div>
