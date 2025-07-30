<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
                <img src="/assets/images/logos/dark-logo.svg" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Books</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route("books") }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-books"></i>
                        </span>
                        <span class="hide-menu">Books</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route("books.borrowed") }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-book-2"></i>
                        </span>
                        <span class="hide-menu">My Books</span>
                    </a>
                </li>

                @if (Auth::user()->role == "admin")
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Members</span>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route("accounts") }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-user-plus"></i>
                            </span>
                            <span class="hide-menu">Accounts</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
