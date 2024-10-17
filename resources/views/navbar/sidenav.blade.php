

<nav id="sidebarMenu" class="col-md-3 col-lg-3 d-md-block sidebar collapse">
                    <div class="position-sticky py-4 px-3 sidebar-sticky">
                        <ul class="nav flex-column h-100">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ route('dashboard') }}">
                                    <i class="bi-house-fill me-2"></i>
                                    Overview
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('budget.index') }}">
                                    <i class="bi-wallet me-2"></i>
                                    My Expenses
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('apparel.index') }}">
                                    <i class="bi-person me-2"></i>
                                    My Wardrobe
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('event.index') }}">
                                    <i class="bi-gear me-2"></i>
                                    Event List
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('wallet.index') }}">
                                    <i class="bi-gear me-2"></i>
                                    Wallet List
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profile') }}">
                                    <i class="bi-gear me-2"></i>
                                    My Profile
                                </a>
                            </li>



                            <li class="nav-item border-top mt-auto pt-2">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="nav-link" style="border: none; background: none; cursor: pointer;">
                                        <i class="bi-box-arrow-left me-2"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </div>
                </nav>