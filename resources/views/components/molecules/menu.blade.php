<ul class="metismenu side-nav">
    <li class="side-nav-title side-nav-item">Halaman Utama</li>

    <li class="side-nav-item {{ Request::is('/') ? 'mm-active' : null }}">
        <a href="apps-chat.html" class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="side-nav-title side-nav-item">Apps</li>

    <li class="side-nav-item">
        <a href="apps-chat.html" class="side-nav-link">
            <i class="uil-comments-alt"></i>
            <span> Chat </span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="javascript: void(0);" class="side-nav-link">
            <i class="uil-store"></i>
            <span> Ecommerce </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="side-nav-second-level" aria-expanded="false">
            <li>
                <a href="apps-ecommerce-products.html">Products</a>
            </li>
            <li>
                <a href="apps-ecommerce-products-details.html">Products Details</a>
            </li>
        </ul>
    </li>
</ul>
