<nav class="navbar-vertical navbar">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <a class="navbar-brand" href="/">
            <img src="{{ asset('images/logo/logo.png') }}" alt="logo" />
            <span class="text-white">{{ env('APP_NAME') }}</span>
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link has-arrow  active " href="{{ route('admin.dashboard') }}">
                <i data-feather="home" class="nav-icon icon-xs me-2"></i>  Dashboard
                </a>
            </li>

            <!-- Nav item -->

            <li class="nav-item">
                <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#categoryMenu" aria-expanded="false" aria-controls="navPages">
                <i
                    data-feather="layers"
                    class="nav-icon icon-xs me-2">
                </i> Category
                </a>
                <div id="categoryMenu" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('category.create') }}">
                            Add Category
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow"  href="{{ route('category.index') }}" >
                            All Category
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#subcatMenu" aria-expanded="false" aria-controls="navPages">
                <i
                    data-feather="layers"
                    class="nav-icon icon-xs me-2">
                </i> Subcategory
                </a>
                <div id="subcatMenu" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('subcategory.create') }}">
                            Add Sub Category
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow"  href="{{ route('subcategory.index') }}" >
                            All Sub Category
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#brandPage" aria-expanded="false" aria-controls="navPages">
                <i
                    data-feather="layers"
                    class="nav-icon icon-xs me-2">
                </i> Brand
                </a>
                <div id="brandPage" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('brand.create') }}">
                            Add Brand
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow"  href="{{ route('brand.index') }}" >
                            All Brand
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#productPage" aria-expanded="false" aria-controls="navPages">
                <i
                    data-feather="layers"
                    class="nav-icon icon-xs me-2">
                </i> Products
                </a>
                <div id="productPage" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('product.add') }}">
                            Add Product
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow"  href="{{ route('product') }}" >
                            Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow"  href="{{ route('all.inactive.product') }}" >
                            Inactive Products
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#orderPage" aria-expanded="false" aria-controls="navPages">
                <i
                    data-feather="layers"
                    class="nav-icon icon-xs me-2">
                </i> Orders
                </a>
                <div id="orderPage" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('order') }}">
                            Orders
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#userPage" aria-expanded="false" aria-controls="navPages">
                <i
                    data-feather="layers"
                    class="nav-icon icon-xs me-2">
                </i> User Manage
                </a>
                <div id="userPage" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('user') }}">
                            All User
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('all.inactive.user') }}">
                            All Inactive User
                            </a>
                        </li>

                    </ul>
                </div>
            </li>


            <!-- Nav item -->
            <li class="nav-item">
                <div class="navbar-heading">Customers</div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link has-arrow " href="" >
                <i data-feather="package" class="nav-icon icon-xs me-2" >
                </i>  Customers
                </a>
            </li>
        </ul>
    </div>
</nav>
