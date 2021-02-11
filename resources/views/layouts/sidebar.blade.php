<!-- sidebar @s -->
<div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="html/index.html" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ asset('assets/images/logo.png')}}" srcset="{{ asset('assets/images/logo2x.png 2x') }}" alt="logo">
                <img class="logo-dark logo-img" src="{{ asset('assets/images/logo-dark.png') }}" srcset="{{ asset('assets/images/logo-dark2x.png 2x')}}" alt="logo-dark">
                <img class="logo-small logo-img logo-img-small" src="{{ asset('assets/images/logo-small.png') }}" srcset="{{ asset('assets/images/logo-small2x.png 2x')}}" alt="logo-small">
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-item @if(\Request::route()->getName() == 'dashboard') active @endif">
                        <a href="{{ route('dashboard') }}" class="nk-menu-link">    
                            <span class="nk-menu-icon"><em class="icon ni ni-cart-fill"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item @if(\Request::route()->getName() == 'board.index' || \Request::route()->getName() == 'board.create' || \Request::route()->getName() == 'board.edit') active @endif">
                        <a href="{{ route('board.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-cart-fill"></em></span>
                            <span class="nk-menu-text">Board</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item @if(\Request::route()->getName() == 'standard.index' || \Request::route()->getName() == 'standard.create' || \Request::route()->getName() == 'standard.edit') active @endif">
                        <a href="{{ route('standard.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-cart-fill"></em></span>
                            <span class="nk-menu-text">Standard</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item @if(\Request::route()->getName() == 'semester.index' || \Request::route()->getName() == 'semester.create' || \Request::route()->getName() == 'semester.edit') active @endif">
                        <a href="{{ route('semester.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-cart-fill"></em></span>
                            <span class="nk-menu-text">Semester</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item @if(\Request::route()->getName() == 'subject.index' || \Request::route()->getName() == 'subject.create' || \Request::route()->getName() == 'subject.edit') active @endif">
                        <a href="{{ route('subject.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-cart-fill"></em></span>
                            <span class="nk-menu-text">Subject</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item @if(\Request::route()->getName() == 'unit.index' || \Request::route()->getName() == 'unit.create' || \Request::route()->getName() == 'unit.edit') active @endif">
                        <a href="{{ route('unit.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-cart-fill"></em></span>
                            <span class="nk-menu-text">Unit</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item @if(\Request::route()->getName() == 'book.index' || \Request::route()->getName() == 'book.create' || \Request::route()->getName() == 'book.edit') active @endif">
                        <a href="{{ route('book.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-cart-fill"></em></span>
                            <span class="nk-menu-text">Book</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    
                    <li class="nk-menu-item @if(\Request::route()->getName() == 'slider.index' || \Request::route()->getName() == 'slider.create' || \Request::route()->getName() == 'slider.edit') active @endif">
                        <a href="{{ route('slider.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-cart-fill"></em></span>
                            <span class="nk-menu-text">Slider</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    
                    
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->