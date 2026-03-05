<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Inventory Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" />
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">

    <link rel="stylesheet" href="{{asset('datatable/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('datatable/responsive.bootstrap4.min.css')}}">
   
  </head>
  <body>
    <div class="container-scroller">
      {{-- <div class="row p-0 m-0 proBanner" id="proBanner">
        <div class="col-md-12 p-0 m-0">
          <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
            <div class="ps-lg-1">
              <div class="d-flex align-items-center justify-content-between">
                <p class="mb-0 font-weight-medium me-3 buy-now-text">Free 24/7 customer support, updates, and more with this template!</p>
                <a href="https://www.bootstrapdash.com/product/purple-bootstrap-admin-template/?utm_source=organic&utm_medium=banner&utm_campaign=buynow_demo" target="_blank" class="btn me-2 buy-now-btn border-0">Get Pro</a>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <a href="https://www.bootstrapdash.com/product/purple-bootstrap-admin-template/"><i class="mdi mdi-home me-3 text-white"></i></a>
              <button id="bannerClose" class="btn border-0 p-0">
                <i class="mdi mdi-close text-white me-0"></i>
              </button>
            </div>
          </div>
        </div>
      </div> --}}
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo " href="index.html"><img src="{{asset('logo.jpg')}}" alt="logo" style="height: 60px; width:110px; margin-top:20px; margin-bottom:10px"/></a>
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('logo.jpg')}}" alt="logo"  style="height: 60px; width:180px; margin-top:20px; margin-bottom:10px; !important" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <div class="search-field d-none d-md-block">
            {{-- <form class="d-flex align-items-center h-100" action="#">
              <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
              </div>
            </form> --}}
          </div>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <img src="{{asset('assets/images/faces/face1.jpg')}}" alt="image">
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black">{{Auth::user()->name}}</p>
                </div>
              </a>
          
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item text-dark" href="{{route('admin.logout')}}">
                  <i class="mdi mdi-logout me-2 text-primary "></i> Signout </a>
              </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>
       
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="{{asset('assets/images/faces/face1.jpg')}}" alt="profile">
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">{{Auth::user()->name}}</span>
                  <span class="text-secondary text-small">{{Auth::user()->name}}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
            <li class="nav-item {{Request::is('admin/dashboard')? 'active':''}}">
              <a class="nav-link" href="{{route('admin.dashboard')}}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>

            {{-- <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Customers</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{route('admin.customer.create')}}">Create</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{route('admin.customer.index')}}">Customers List</a></li>
                </ul>
              </div>
            </li> --}}
            <li class="nav-item {{Request::is('admin/customer*')? 'active':''}}">
              <a class="nav-link" href="{{route('admin.customer.index')}}">
                <span class="menu-title">Customers</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li> 
            <li class="nav-item {{Request::is('admin/category*')? 'active':''}}">
              <a class="nav-link" href="{{route('admin.category.index')}}">
                <span class="menu-title">Categories</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li> 
            <li class="nav-item {{Request::is('admin/product*')? 'active':''}}">
              <a class="nav-link" href="{{route('admin.product.index')}}">
                <span class="menu-title">Products</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li> 
            {{-- <li class="nav-item {{Request::is('admin/import-file')? 'active':''}}">
              <a class="nav-link" href="{{route('admin.import-customers')}}">
                <span class="menu-title">Import Customers</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li> --}}
           
            {{-- <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-medical-bag menu-icon"></i>
              </a>
              <div class="collapse" id="general-pages">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{route('admin.user.create')}}">Create</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{route('admin.user.index')}}">User List</a></li>
                </ul>
              </div>
            </li> --}}
            <li class="nav-item {{Request::is('admin/user*')? 'active':''}}">
              <a class="nav-link" href="{{route('admin.user.index')}}">
                <span class="menu-title">Users</span>
                <i class="mdi mdi-account menu-icon"></i>
              </a>
            </li>

            {{-- <li class="nav-item {{Request::is('admin/create/inventory')? 'active':''}}">
              <a class="nav-link" href="{{route('admin.inventory')}}">
                <span class="menu-title">Inventory</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li> --}}
            <li class="nav-item {{Request::is('admin/create/inventory*')? 'active':''}}">
              <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                <span class="menu-title">Inventory</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-medical-bag menu-icon"></i>
              </a>
              <div class="collapse" id="general-pages">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{route('admin.inventory')}}">Add Inventory</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{route('admin.show.inventory')}}">View Inventory</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{route('admin.edit.inventory')}}">Edit Inventory</a></li>
                </ul>
              </div>
            </li>

          </ul>
        </nav>
        <!-- partial -->
        @yield('content')
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('assets/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/misc.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{asset('assets/js/dashboard.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>
    <!-- End custom js for this page -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>

     <!---Data table----->
     <script src="{{asset('datatable/jquery.dataTables.min.js')}}"></script>
     <script src="{{asset('datatable/dataTables.bootstrap4.min.js')}}"></script>
     <script src="{{asset('datatable/dataTables.responsive.min.js')}}"></script>
     <script src="{{asset('datatable/responsive.bootstrap4.min.js')}}"></script>
    @toastr_render
    @yield('scripts')
  </body>
</html>