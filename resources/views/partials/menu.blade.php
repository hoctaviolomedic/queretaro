<li>
    @if(!$modulo->submodulos->count())
    <a class="collapsible-header waves-effect" href="{{ !empty($modulo->url) ? companyAction($modulo->url) : '#' }}">
        <i class='material-icons'>{{ $modulo->icono }}</i>
        <span class="menu-text">{{ $modulo->nombre }}</span>
        
    </a>
    @else
    <ul class="collapsible collapsible-accordion">
        <li>
            <a class="collapsible-header" href="#">
            	<i class='material-icons left'>{{ $modulo->icono }}</i>
                <span class="menu-text">{{ $modulo->nombre }}</span>
                <i class="material-icons right grey-text">expand_more</i>
            </a>
            <div class="collapsible-body">
                <ul>
                    @each('partials.menu', $modulo->submodulos, 'modulo')
                </ul>
            </div>
        </li>
    </ul>
    @endif
</li>