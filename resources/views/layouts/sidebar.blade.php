<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">

            <li class="nav-item {{ request()->is('products/*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('products.index')}}">
                    <i class="nav-icon i-Shop"></i>
                    <span class="nav-text">Productos</span>
                </a>
                <div class="triangle"></div>
            </li>

        </ul>
    </div>

    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">

    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->
