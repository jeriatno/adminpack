@if (backpack_auth()->check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar" style="position: fixed;">
      <!-- sidebar: style can be found in sidebar.less & base/inc/style.blade.php-->
        @include('backpack::inc.style')
      <section class="sidebar scrollable-sidebar">
        <!-- Sidebar user panel -->
        @include('backpack::inc.sidebar_user_panel')

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree" style="margin-bottom: 70px">
          {{-- <li class="header">{{ trans('backpack::base.administration') }}</li> --}}
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->

          @include('backpack::inc.sidebar_content')

          <!-- ======================================= -->
          {{-- <li class="header">Other menus</li> --}}
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
