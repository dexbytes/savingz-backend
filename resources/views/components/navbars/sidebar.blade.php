<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0 p-4 d-flex align-items-center text-wrap" href="{{ route('dashboard') }}">
                <img src="{{ asset('assets') }}/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-2 font-weight-bold text-white">
                 @role('Provider') {{session('store_name')}} |  @endrole {{config('app.name')}}
                </span>                
            </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mb-2 mt-0">
                <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-white {{ strpos(Request::route()->uri(), 'account')=== false ? '' : 'active' }} " aria-controls="ProfileNav"
                    role="button" aria-expanded="false">
                    @if (auth()->user()->picture)
                    <img src="/storage/{{(auth()->user()->picture)}}" alt="avatar" class="avatar">
                    @else
                    <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar" class="avatar">
                    @endif
                    <span class="nav-link-text ms-2 ps-1">{{ auth()->user()->name }}</span>
                </a>
                <div class="collapse {{ strpos(Request::route()->uri(), 'account')=== false ? '' : 'show' }} " id="ProfileNav" style="">
                    <ul class="nav ">
                        
                    @can('edit-profile')
                        <li class="nav-item  {{ Route::currentRouteName() == 'edit-profile' ? 'active' : '' }} ">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'edit-profile' ? 'active' : '' }} " href="{{ route('edit-profile') }}">
                               <span class="sidenav-normal  ms-3  ps-1"> My Profile </span>
                            </a>
                        </li>
                    @endcan

                        <li class="nav-item">
                            <livewire:auth.logout />
                        </li>
                    </ul>
                </div>
            </li>
            <hr class="horizontal light mt-0">
            <li class="nav-item  {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }} ">
                <a data-bs-toggle="" href="{{ route('dashboard') }}"
                    class="nav-link text-white {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }} "
                    aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                    <span class="material-symbols-outlined">
                        dashboard
                        </span>
                    <span class="nav-link-text ms-2 ps-1">Dashboard</span>
                </a>
            </li>
        @can('user-management')
            <li class="nav-item mt-3">
               <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">USERS</h6>
            </li>

        @can('user-management')
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#users"
                    class="nav-link text-white {{ strpos(Request::route()->uri(), 'users') === false ? '' : 'active' }}  "
                    aria-controls="users" role="button" aria-expanded="false">
                     <span class="material-symbols-outlined">
                        groups
                      </span>
                    <span class="nav-link-text ms-2 ps-1">Users</span>
                </a>
                <div class="collapse {{ strpos(Request::route()->uri(), 'users') === false ? '' : 'show' }} "
                    id="users">

                    <ul class="nav nav-sm flex-column ms-2">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'user-management' && Route::current()->parameter('role') == '' ? 'active' : '' }}"
                                href="{{ route('user-management') }}">
                                <span class="material-symbols-outlined">
                                    person
                                </span>
                                <span class="sidenav-normal ms-3 ps-1"> All Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'add-user' && Route::current()->parameter('role') == '' ? 'active' : '' }}"
                                href="{{ route('add-user') }}">
                                <span class="material-symbols-outlined">
                                    person_add
                                </span>
                                <span class="sidenav-normal ms-3 ps-1"> Add New User</span>
                            </a>
                        </li>
                    
                        {{-- <li class="nav-item">
                            <a class="nav-link text-white {{ (Route::currentRouteName() == 'user-management' && Route::current()->parameter('role') == 'provider') ? 'active' : '' }}"
                                href="{{  route('user-management', ['role' => 'provider']) }}">
                                <span class="material-symbols-outlined">
                                    person
                                </span>
                                <span class="sidenav-normal ms-3 ps-1"> Providers </span>
                            </a>
                        </li> --}}
                    
                        {{-- <li class="nav-item">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'user-management'  && Route::current()->parameter('role') == 'customer' ? 'active' : '' }}"
                                href="{{  route('user-management', ['role' => 'customer']) }}">
                                <span class="material-symbols-outlined">
                                    person
                                </span>
                                <span class="sidenav-normal ms-3 ps-1"> Customers </span>
                            </a>
                        </li> --}}
                   
                        {{-- <li class="nav-item">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'user-management'  && Route::current()->parameter('role') == 'driver' ? 'active' : '' }}"
                                href="{{  route('user-management', ['role' => 'driver']) }}">
                                <span class="material-symbols-outlined">
                                    person
                                </span>
                                <span class="sidenav-normal  ms-3 ps-1"> Drivers </span>
                            </a>
                        </li> --}}
                    </ul>
                    @endcan
               
                    @can('request-management')     
                        <li class="nav-item ">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'tickets') === false ? '' : 'active' }}   "
                                data-bs-toggle="collapse" aria-expanded="false" href="#ticketsExample">
                                <span class="material-symbols-outlined">
                                manage_accounts
                                </span>
                                <span class="sidenav-normal  ms-2 ps-1"> Requests <b class="caret"></b></span>
                            </a>
                            <div class="collapse {{ strpos(Request::route()->uri(), 'tickets') === false ? '' : 'show' }} "
                                id="ticketsExample">
                                <ul class="nav nav-sm flex-column ms-2">
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'ticket-management' ? 'active' : '' }} "
                                            href="">
                                            <span class="material-symbols-outlined">
                                                list
                                            </span>
                                            <span class="sidenav-normal  ms-3  ps-1"> All </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'ticket-management' ? 'active' : '' }}"
                                            href="">
                                            <span class="material-symbols-outlined">
                                             pending_actions
                                            </span>
                                            <span class="sidenav-normal  ms-3  ps-1"> Pending Requests </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                @endcan   
                @endcan
            
                    {{-- @can('store-management', 'unverified-stores', 'unverified-driver', 'store-type-management')
                        <li class="nav-item mt-3">
                            <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">MARKETPLACE</h6>
                        </li>
                    @can('unverified-stores')
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{ route('store-management' , ['application_status' => 'approved']) }}"
                                class="nav-link text-white {{ Route::currentRouteName() == 'store-management' ? 'active' : '' }} "
                                aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                                <span class="material-symbols-outlined">
                                    store
                                    </span>
                                <span class="nav-link-text ms-2 ps-1">Stores</span>
                            </a>
                        </li>
                    @endcan
                    @can('unverified-stores')
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{ route('unverified-stores', ['application_status' => 'waiting']) }}"
                                class="nav-link text-white {{ Route::currentRouteName() == 'unverified-stores'? 'active' : '' }}"
                                aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                                <span class="material-symbols-outlined">
                                    unpublished
                                    </span>
                                <span class="nav-link-text ms-2 ps-1">Unverified Stores</span>
                            </a>
                        </li>
                    @endcan
                    @can('unverified-driver')
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'unverified-driver' ? 'active' : '' }}"
                                href="{{  route('unverified-driver', ['role' => 'driver', 'account_status' => 'waiting'] ) }}">
                                <span class="material-symbols-outlined">
                                no_accounts
                                </span>
                                <span class="sidenav-normal  ms-2 ps-1">Unverified Drivers </span>
                            </a>
                        </li>
                    @endcan
                    @can('store-type-management')
                        <li class="nav-item ">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'store-types') === false ? '' : 'active' }}" href="{{ route('store-type-management') }}">
                                <span class="material-symbols-outlined">
                                    local_convenience_store
                                    </span>
                                <span class="sidenav-normal ms-2 ps-1"> Store Types</span>
                            </a>
                        </li>
                    @endcan
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{ route('investment-type-management') }}"
                                class="nav-link text-white {{ strpos(Request::route()->uri(), 'investment-types') === false ? '' : 'active' }}"
                                aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                                <span class="material-symbols-outlined">
                                    money
                                    </span>
                                <span class="nav-link-text ms-2 ps-1">Investment Types</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href=""
                                class="nav-link text-white "
                                aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                                <span class="material-symbols-outlined">
                                    settings
                                    </span>
                                <span class="nav-link-text ms-2 ps-1">Setting</span>
                            </a>
                        </li>
                        </li>
                    @endcan --}}

                        {{-- <li class="nav-item mt-3">
                            <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">ECOMMERCE</h6>
                        </li> --}}

                     {{-- @can('product-management', 'product-category-management', 'product-tag-management', 'product-addon-management')
                        <li class="nav-item ">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'products') === false ? '' : 'active' }}  "
                                data-bs-toggle="collapse" aria-expanded="false" href="#projectsExample">
                                <span class="material-symbols-outlined">
                                inventory_2
                                </span>
 
                                <span class="sidenav-normal  ms-2 ps-1"> Products <b class="caret"></b></span>
                          </a>
                            <div class="collapse {{ strpos(Request::route()->uri(), 'products') === false ? '' : 'show' }}   "
                                id="projectsExample">
                                <ul class="nav nav-sm flex-column ms-2">
                                @can('product-management')
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'product-management' ? 'active' : '' }} "
                                            href="{{ route('product-management') }}">
                                            <span class="material-symbols-outlined">
                                            inventory
                                            </span>
                                            <span class="sidenav-normal ms-2 ps-1"> Products </span>
                                        </a>
                                    </li>
                                @endcan
                                @can('product-category-management')
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'product-category-management' ? 'active' : '' }}"
                                            href="{{ route('product-category-management') }}">
                                            <span class="material-symbols-outlined">
                                            category
                                            </span>
 
                                            <span class="sidenav-normal ms-2 ps-1"> Categories </span>
 
                                        </a>
 
                                    </li>
                                @endcan
                                @can('product-addon-management')
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'product-addon-management' ? 'active' : '' }}"
                                            href="{{ route('product-addon-management') }}">
                                            <span class="material-symbols-outlined">
                                            menu_book
                                            </span>
                                            <span class="sidenav-normal ms-2 ps-1"> Addon Options </span>
                                        </a>
                                    </li>
                                @endcan
                                @can('product-tag-management')
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'products/tags')=== false ? '' : 'active' }}"
                                            href="{{ route('product-tag-management') }}">
                                            <span class="material-symbols-outlined">
                                            label
                                            </span>
                                            <span class="sidenav-normal ms-3 ps-1"> Tags </span>
                                        </a>
                                    </li>
                                @endcan
                                </ul>
                            </div>
                        </li>
                        @endcan --}}

                        {{-- @can('order-management')
                        <li class="nav-item ">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'orders')=== false ? '' : 'active' }} "
                                data-bs-toggle="collapse" aria-expanded="false" href="#vrExamples">
                                <span class="material-symbols-outlined">
                                    shopping_cart
                                    </span>
                                <span class="sidenav-normal ms-2 ps-1"> Orders <b class="caret"></b></span>
                            </a>
                            <div class="collapse {{ strpos(Request::route()->uri(), 'orders')=== false ? '' : 'show' }} "
                                id="vrExamples">
                                <ul class="nav nav-sm flex-column ms-2">
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ (Route::currentRouteName() == 'order-management' && Route::current()->parameter('orderStatus') == '') ? 'active' : '' }}"
                                            href="{{ route('order-management') }}">
                                            <span class="material-symbols-outlined">
                                            view_list
                                            </span>
                                            <span class="sidenav-normal ms-2 ps-1"> All </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ (Route::currentRouteName() == 'order-management' && Route::current()->parameter('orderStatus') == 'pending') ? 'active' : '' }}"
                                            href="{{ route('order-management', ['orderStatus' => 'pending']) }}">
                                            <span class="material-symbols-outlined">
                                            pending_actions
                                            </span>
                                            <span class="sidenav-normal ms-2 ps-1"> Pending </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ (Route::currentRouteName() == 'order-management' && Route::current()->parameter('orderStatus') == 'completed') ? 'active' : '' }}"
                                            href="{{ route('order-management', ['order_status' => 'completed']) }}">
                                            <span class="material-symbols-outlined">
                                            fact_check
                                            </span>
                                            <span class="sidenav-normal ms-2 ps-1"> Completed </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endcan --}}
        @role('Admin')                
            <li class="nav-item">
                <hr class="horizontal light" />
                <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">Setting</h6>
            </li>
            @can('role-management')
            <li class="nav-item ">
                <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'roles') === false ? '' : 'active' }}   "
                    data-bs-toggle="collapse" aria-expanded="false" href="#usersExample">
                    <span class="material-symbols-outlined">
                        group
                        </span>
                    <span class="sidenav-normal  ms-2 ps-1"> Roles <b class="caret"></b></span>
                </a>
                <div class="collapse {{ strpos(Request::route()->uri(), 'roles') === false ? '' : 'show' }} "
                    id="usersExample">
                    <ul class="nav nav-sm flex-column ms-2">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'role-management'  || Route::currentRouteName() == 'edit-role' ? 'active' : '' }} "
                                href="{{ route('role-management') }}">
                                <span class="material-symbols-outlined">
                                    table_view
                                </span>
                                <span class="sidenav-normal  ms-3  ps-1"> List </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'new-role' ? 'active' : '' }}"
                                href="{{ route('new-role') }}">
                                <span class="material-symbols-outlined">
                                    group_add
                                </span>
                                <span class="sidenav-normal  ms-3  ps-1"> Add New Role </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endcan
        @can('faq-management')
            <li class="nav-item">
                <a data-bs-toggle="" href="{{ route('faq-management') }}"
                    class="nav-link text-white {{ strpos(Request::route()->uri(), 'faq') === false ? '' : 'active'  }}"
                    aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                    <span class="material-symbols-outlined">
                        quiz
                        </span>
                    <span class="nav-link-text ms-2 ps-1">FAQ</span>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="" href="{{ route('page-management') }}"
                    class="nav-link text-white {{ strpos(Request::route()->uri(), 'pages') === false ? '' : 'active' }}"
                    aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                    <span class="material-symbols-outlined">
                        pages
                        </span>
                    <span class="nav-link-text ms-2 ps-1">Pages</span>
                </a>
            </li>
        @endcan
        @can('country-management', 'state-management', 'city-management')
            <li class="nav-item ">
                <a class="nav-link text-white  {{ strpos(Request::route()->uri(), 'location')=== false ? '' : 'active' }}"
                    data-bs-toggle="collapse" aria-expanded="false" href="#LocationExample">
                    <span class="material-symbols-outlined">
                    public
                        </span>
                    <span class="sidenav-normal  ms-2 ps-1"> Location <b class="caret"></b></span>
                </a>
                <div class="collapse {{ strpos(Request::route()->uri(), 'location')=== false ? '' : 'show' }}"
                    id="LocationExample">
                    <ul class="nav nav-sm flex-column ms-2">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'country-management' ? 'active' : '' }}"
                                href="{{ route('country-management') }}">
                                <span class="material-symbols-outlined">
                                    home_pin
                                    </span>
                                <span class="nav-link-text ms-2 ps-1">Country</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'state-management' ? 'active' : '' }}"
                                href="{{ route('state-management') }}">
                                <span class="material-symbols-outlined">
                                    flag
                                    </span>
                                <span class="nav-link-text ms-2 ps-1">State</span>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'city-management' ? 'active' : '' }}"
                                href="{{ route('city-management') }} ">
                                <span class="material-symbols-outlined">
                                    pin_drop
                                    </span>
                                <span class="nav-link-text ms-2 ps-1">City</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endcan
            <li class="nav-item">
                <a data-bs-toggle="" href=""
                    class="nav-link text-white "
                    aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                    <span class="material-symbols-outlined">
                        list
                        </span>
                    <span class="nav-link-text ms-2 ps-1">Basic Settings</span>
                </a>
            </li>
        @endrole                    
        </ul>
    </div>


</aside>
