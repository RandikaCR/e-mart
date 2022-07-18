<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            E Mart <span>Marketplace
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/orders/create') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">POS</span>
                </a>
            </li>

            <li class="nav-item nav-category">Orders Manager</li>
            <li class="nav-item">
                <a href="{{ url('orders') }}" class="nav-link">
                    <i class="link-icon" data-feather="message-square"></i>
                    <span class="link-title">All Orders</span>
                </a>
            </li>

            <li class="nav-item nav-category">Products Manager</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#products-manager" role="button" aria-expanded="false" aria-controls="products-manager">
                    <i class="link-icon" data-feather="book"></i>
                    <span class="link-title">Products</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="products-manager">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('products') }}" class="nav-link">All Products</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('products/create') }}" class="nav-link">Add New</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item nav-category">CRM</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#customers-manager" role="button" aria-expanded="false" aria-controls="customers-manager">
                    <i class="link-icon" data-feather="book"></i>
                    <span class="link-title">Customers</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="customers-manager">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('customers') }}" class="nav-link">All Customers</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('customers/create') }}" class="nav-link">Add New</a>
                        </li>
                    </ul>
                </div>
            </li>

            @if( Auth::user()->user_type_id == 1 )
            <li class="nav-item nav-category">Accounts Manager</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#users-manager" role="button" aria-expanded="false" aria-controls="users-manager">
                    <i class="link-icon" data-feather="book"></i>
                    <span class="link-title">Users</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="users-manager">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('users') }}" class="nav-link">All Users</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('users/create') }}" class="nav-link">Add New</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

        </ul>
    </div>
</nav>
