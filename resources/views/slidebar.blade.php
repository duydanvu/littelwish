<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img  class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Smart Search Apps</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ Request::is('/report') ? 'active' : '' }}">
                            <a href="/report" class="nav-link ">
                                <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                                <p>Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="setting" class=" nav-link ">
                                <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                                <p>Setting</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('product/getlist') ? 'active' : '' }}">
                            <a href="product/getlist" class="nav-link " onclick="product1Minute()">
                                <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                                <p>Product</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('collections/getlist') ? 'active' : '' }}">
                            <a href="collections/getlist" class="nav-link">
                                <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                                <p>Collection</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

