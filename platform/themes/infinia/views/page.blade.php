@php
    Theme::set('breadcrumbEnabled', $page->getMetaData('breadcrumb_enabled', true));
@endphp

{!! apply_filters(
    PAGE_FILTER_FRONT_PAGE_CONTENT,
    Html::tag('div', BaseHelper::clean($page->content), ['class' => 'ck-content'])->toHtml(),
    $page
) !!}
