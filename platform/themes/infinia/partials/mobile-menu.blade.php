<ul{!! BaseHelper::clean($options) !!}>
    @foreach($menu_nodes as $key => $row)
        <li @class(['has-children' => $row->has_child])>
            <a @class(['active' => $row->active, $row->css_class]) href="{{ $row->url }}" target="{{ $row->target }}">
                {!! BaseHelper::clean($row->icon_html) !!}
                {{ $row->title }}
            </a>

            @if($row->has_child)
                {!! Menu::renderMenuLocation('main-menu', ['view' => 'main-menu', 'menu' => $menu, 'menu_nodes' => $row->child, 'options' => ['class' => 'sub-menu']]) !!}
            @endif
        </li>
    @endforeach
</ul>

{!! Theme::partial('language-switcher-mobile') !!}
