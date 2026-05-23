<!DOCTYPE html>
<html lang="en">
  <head>
    @php
      $enablePreloader = app()->environment('production') && !in_array(request()->getHost(), ['localhost', '127.0.0.1', '::1'], true);
    @endphp
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if(Auth::user()->usertype != 2)
    <title>Admin Panel</title>
    @endif
    @if(Auth::user()->usertype == 2)
    <title>User Panel</title>
    @endif
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('admin/assets//vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets//vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('admin/assets//vendors/jvectormap/jquery-jvectormap.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets//vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets//vendors/owl-carousel-2/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets//vendors/owl-carousel-2/owl.theme.default.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('admin/assets//css/style.css')}}">
    @if($enablePreloader)
      <link rel="stylesheet" href="{{ asset('assets/css/preloader.css') }}">
    @endif
    <!-- End layout styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">



    <link rel="shortcut icon" href="{{asset('admin/assets//images/favicon.png')}}" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
/* Theme Variables */
:root {
    --admin-bg: #0f172a;
    --admin-card-bg: #1e293b;
    --admin-text: #f8fafc;
    --admin-text-muted: #94a3b8;
    --admin-border: rgba(255, 255, 255, 0.1);
    --admin-navbar-bg: rgba(15, 23, 42, 0.9);
    --admin-sidebar-bg: #0f172a;
    --admin-accent: #3b82f6;
    --admin-table-header: rgba(255, 255, 255, 0.05);
}

body.admin-light-mode {
    --admin-bg: #f3f4f6;
    --admin-card-bg: #ffffff;
    --admin-text: #111827;
    --admin-text-muted: #6b7280;
    --admin-border: #e5e7eb;
    --admin-navbar-bg: rgba(255, 255, 255, 0.95);
    --admin-sidebar-bg: #ffffff;
    --admin-table-header: #f9fafb;
}

/* Premium Dashboard Overrides */
body, .container-scroller, .page-body-wrapper, .main-panel, .content-wrapper {
    background-color: var(--admin-bg) !important;
    color: var(--admin-text) !important;
    font-family: 'Poppins', sans-serif;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.sidebar {
    background: var(--admin-sidebar-bg) !important;
    border-right: 1px solid var(--admin-border);
}

.sidebar .nav .nav-item .nav-link {
    color: var(--admin-text-muted) !important;
}

.sidebar .nav .nav-item.active > .nav-link,
.sidebar .nav .nav-item:hover > .nav-link {
    color: var(--admin-text) !important;
    background: var(--admin-table-header) !important;
}

.navbar {
    background: var(--admin-navbar-bg) !important;
    backdrop-filter: blur(12px) !important;
    -webkit-backdrop-filter: blur(12px) !important;
    border-bottom: 1px solid var(--admin-border);
    transition: background-color 0.3s ease;
}

.navbar .navbar-nav .nav-item .nav-link {
    color: var(--admin-text-muted) !important;
}

.navbar .navbar-nav .nav-item .nav-link:hover {
    color: var(--admin-text) !important;
}

.card {
    background-color: var(--admin-card-bg) !important;
    border: 1px solid var(--admin-border) !important;
    border-radius: 1rem !important;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1) !important;
}

/* Text Utilities */
.text-muted { color: var(--admin-text-muted) !important; }
h1, h2, h3, h4, h5, h6, p, span, div { color: var(--admin-text); }
.navbar-profile-name { color: var(--admin-text) !important; }

/* Table Overrides */
.table {
    color: var(--admin-text) !important;
}

.table thead th {
    background-color: var(--admin-table-header) !important;
    border-bottom: 1px solid var(--admin-border) !important;
    color: var(--admin-text-muted) !important;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
}

.table tbody td {
    border-bottom: 1px solid var(--admin-border) !important;
    vertical-align: middle;
    color: var(--admin-text) !important;
}

/* Modal & Dropdown Overrides */
.modal-content, .dropdown-menu {
    background-color: var(--admin-card-bg) !important;
    border: 1px solid var(--admin-border) !important;
    color: var(--admin-text) !important;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2) !important;
}

.dropdown-item {
    color: var(--admin-text-muted) !important;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: var(--admin-bg) !important;
    color: var(--admin-text) !important;
}

/* Buttons Overrides */
.btn {
    border-radius: 0.5rem !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
}

.btn-primary { background-color: #3b82f6 !important; border: none !important; }
.btn-success { background-color: #10b981 !important; border: none !important; }
.btn-danger { background-color: #ef4444 !important; border: none !important; }
.btn-warning { background-color: #f59e0b !important; border: none !important; }
.btn-info { background-color: #0ea5e9 !important; border: none !important; }

.btn:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
}

/* Form Controls */
.form-control, .form-select {
    background-color: var(--admin-bg) !important;
    border: 1px solid var(--admin-border) !important;
    color: var(--admin-text) !important;
    border-radius: 0.5rem !important;
}

.form-control:focus, .form-select:focus {
    border-color: var(--admin-accent) !important;
    box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25) !important;
}

.input-group-text {
    background-color: var(--admin-table-header) !important;
    border-color: var(--admin-border) !important;
    color: var(--admin-text-muted) !important;
}

/* Badges & Icons */
.icon-box-success { background: rgba(16, 185, 129, 0.1) !important; color: #10b981 !important; }
.icon-box-danger { background: rgba(239, 68, 68, 0.1) !important; color: #ef4444 !important; }
.icon-box-warning { background: rgba(245, 158, 11, 0.1) !important; color: #f59e0b !important; }

/* Global table responsive fix */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    width: 100%;
}
table { width: 100% !important; }
</style>
  </head>
  <body data-app-env="{{ app()->environment() }}">
    @if($enablePreloader)
      @include('partials.preloader')
    @endif
    <div class="container-scroller">

      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        @if(Auth::user()->usertype != 2)
          <a class="sidebar-brand brand-logo" href="/redirects" style="color:white;text-decoration:none;">Admin Panel</a>
        @endif
        @if(Auth::user()->usertype == 2)
          <a class="sidebar-brand brand-logo" href="/redirects" style="color:white;text-decoration:none;">User Panel</a>
        @endif
          <a class="sidebar-brand brand-logo-mini" href="index.html"><img src="{{asset('storage/images/logo.png')}}" alt="logo" style="width:30px;height:auto;" /></a>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle"
                      src="{{ Auth::user()->profile_photo_path && file_exists(storage_path('app/public/' . Auth::user()->profile_photo_path))
                              ? asset('storage/' . Auth::user()->profile_photo_path)
                              : Storage::url('images/admin.jpeg') }}"
                      alt="Profile Photo">


                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name }}</h5>
                  @if(Auth::user()->usertype == 1)
                  <span> Super Admin</span>
                  @endif
                  @if(Auth::user()->usertype == 3)
                  <span>Sub Admin</span>
                  @endif
                  @if(Auth::user()->usertype == 2)
                  <span>Delivery Boy</span>
                  @endif
                </div>
              </div>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword  text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar-today text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                  </div>
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="/redirects">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          @if(Auth::user()->usertype != 2)
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.food-menu') }}">
              <span class="menu-icon">
                <i class="mdi mdi-food"></i>
              </span>
              <span class="menu-title">Food Menu</span>
            </a>
          </li>


          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.chefs') }}">
              <span class="menu-icon">
                <i class="mdi mdi-food"></i>
              </span>
              <span class="menu-title">Chefs</span>
            </a>
          </li>
          @endif

          <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-file-document-box"></i>
              </span>
              <span class="menu-title">Orders</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('admin.orders-incomplete') }}">Pending Orders</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('admin.orders.process') }}">Processing Order</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('admin.orders-complete') }}">Complete Orders</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('admin.orders.cancel') }}">Cancelled Order</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('admin.order.location') }}">Update Location</a></li>

              </ul>
            </div>
          </li>
          <!--
          <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-food"></i>
              </span>
              <span class="menu-title">Food Menu</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Add Menu</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Update Menu</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Delete Menu</a></li>
              </ul>
            </div>
          </li>
          -->

          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.reservations') }}">
              <span class="menu-icon">
                <i class="mdi mdi-chart-bar"></i>
              </span>
              <span class="menu-title">Reservation</span>
            </a>
          </li>
          @if(Auth::user()->usertype == 1)
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.show') }}">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple-plus"></i>
              </span>
              <span class="menu-title">Admin</span>
            </a>
          </li>
          @endif


          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.customer') }}">
              <span class="menu-icon">
                <i class="mdi mdi-account-plus"></i>
              </span>
              <span class="menu-title">Customer</span>
            </a>
          </li>

          @if(Auth::user()->usertype == 1)


          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.delivery-boy') }}">
              <span class="menu-icon">
                <i class="mdi mdi-account-plus"></i>
              </span>
              <span class="menu-title">Delivery Boy</span>
            </a>
          </li>

          @endif


          @if(Auth::user()->usertype != 2)

          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.coupon') }}">
              <span class="menu-icon">
                <i class="mdi mdi-account-card-details"></i>
              </span>
              <span class="menu-title">Coupon</span>
            </a>
          </li>

          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.charge') }}">
              <span class="menu-icon">
                <i class="mdi mdi-bank"></i>
              </span>
              <span class="menu-title">Charge</span>
            </a>
          </li>

          @endif



        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="/redirects"><img src="{{asset('storage/images/logo.png')}}" alt="logo" style="width:30px;height:auto;" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-center">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav w-100 justify-content-center">
              <li class="nav-item d-none d-lg-block" style="width: 100%; max-width: 400px;">
                <form action="{{ route('admin.food-menu') }}" method="GET" class="nav-link mt-2 mt-md-0 search" style="width: 100%;">
                  <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0" style="border: 1px solid var(--admin-border); border-right: none;">
                        <i class="mdi mdi-magnify text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search products..." value="{{ request('search') }}" style="border: 1px solid var(--admin-border); border-left: none;">
                  </div>
                </form>
              </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right align-items-center" style="gap: 15px;">
              <li class="nav-item d-none d-lg-block">
                <a class="nav-link" href="#" title="Grid View">
                  <i class="mdi mdi-view-grid"></i>
                </a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-email"></i>
                  <span class="count bg-success"></span>
                </a>
              </li>
              <li class="nav-item">
                <!-- Dark / Light Mode Toggle -->
                <button id="admin-theme-toggle" class="nav-link d-flex align-items-center justify-content-center" onclick="toggleAdminTheme()" style="background:none;border:none;cursor:pointer;color:inherit;font-size:20px;padding:8px;border-radius:50%;transition: background-color 0.3s;" title="Toggle theme">
                  <span id="admin-theme-icon">☀️</span>
                </button>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown" style="padding: 0;">
                  <div class="navbar-profile d-flex align-items-center">
                    <img class="img-xs rounded-circle"
                        src="{{ Auth::user()->profile_photo_path && file_exists(storage_path('app/public/' . Auth::user()->profile_photo_path))
                                ? asset('storage/' . Auth::user()->profile_photo_path)
                                : Storage::url('images/admin.jpeg') }}"
                        alt="Profile Photo" style="width: 35px; height: 35px; object-fit: cover;">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name ms-2">{{ Auth::user()->name }}</p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Profile</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="{{ route('user.profile') }}">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <form action="{{ route('admin.logout') }}" method="post" id="logout-form">
                    @csrf
                    <button class="dropdown-item preview-item" type="submit">
                      <div class="preview-thumbnail">
                        <div class="preview-icon bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                          <i class="mdi mdi-logout text-danger"></i>
                        </div>
                      </div>
                      <div class="preview-item-content">
                        <p class="preview-subject mb-1">Log out</p>
                      </div>
                    </button>
                  </form>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">


          @yield('container')



            </div>



          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright &copy; MidwayCafe {{ date('Y') }}. All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><a href="/" target="_blank">Go to Customer Site</a></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{asset('admin/assets//vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('admin/assets//vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admin/assets//vendors/progressbar.js/progressbar.min.js')}}"></script>
    <script src="{{asset('admin/assets//vendors/jvectormap/jquery-jvectormap.min.js')}}"></script>
    <script src="{{asset('admin/assets//vendors/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{asset('admin/assets//vendors/owl-carousel-2/owl.carousel.min.js')}}"></script>
    <script src="{{asset('admin/assets//js/jquery.cookie.js')}}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('admin/assets//js/off-canvas.js')}}"></script>
    <script src="{{asset('admin/assets//js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('admin/assets//js/misc.js')}}"></script>
    <script src="{{asset('admin/assets//js/settings.js')}}"></script>
    <script src="{{asset('admin/assets//js/todolist.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{asset('admin/assets//js/dashboard.js')}}"></script>
    @if($enablePreloader)
      <script src="{{ asset('assets/js/preloader.js') }}"></script>
    @endif



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>





    <!-- End custom js for this page -->
    <script>
    /* Admin Panel: Theme Persistence */
    (function() {
        const theme = localStorage.getItem('admin-theme') || 'dark';
        if (theme === 'light') {
            document.body.classList.add('admin-light-mode');
        } else {
            document.body.classList.remove('admin-light-mode');
        }
        updateThemeIcon(theme === 'light');
    })();

    function toggleAdminTheme() {
        const isLight = document.body.classList.toggle('admin-light-mode');
        const theme = isLight ? 'light' : 'dark';
        localStorage.setItem('admin-theme', theme);
        updateThemeIcon(isLight);
    }

    function updateThemeIcon(isLight) {
        const icon = document.getElementById('admin-theme-icon');
        if (icon) {
            icon.textContent = isLight ? '🌙' : '☀️';
            icon.parentElement.title = isLight ? 'Switch to Dark Mode' : 'Switch to Light Mode';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const isLight = document.body.classList.contains('admin-light-mode');
        updateThemeIcon(isLight);
    });
    </script>
    <script>
      // Securely expose specific environment variables to the frontend
      window.GOOGLE_MAPS_API_KEY = "{{ config('services.google.maps_api_key') }}";
    </script>
  </body>
</html>



