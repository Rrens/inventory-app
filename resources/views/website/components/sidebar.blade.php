 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="index3.html" class="brand-link">
         <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
         <span class="brand-text font-weight-light">Inventory</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
             </div>
             <div class="info">
                 <a href="#" class="d-block">Alexander Pierce</a>
             </div>
         </div>

         <!-- SidebarSearch Form -->
         <div class="form-inline">
             <div class="input-group" data-widget="sidebar-search">
                 <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                     aria-label="Search">
                 <div class="input-group-append">
                     <button class="btn btn-sidebar">
                         <i class="fas fa-search fa-fw"></i>
                     </button>
                 </div>
             </div>
         </div>

         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <li class="nav-item menu-open">
                     <a href="#" class="nav-link {{ $active_group == 'master' ? 'active' : '' }}">
                         <i class="nav-icon fas fa-user-tie"></i>
                         <p>
                             Master
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ route('master.barang.index') }}"
                                 class="nav-link {{ $active == 'barang' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Barang</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('master.supplier.index') }}"
                                 class="nav-link {{ $active == 'supplier' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Supplier</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item menu-open">
                     <a href="#" class="nav-link {{ $active_group == 'riwayat' ? 'active' : '' }}">
                         <i class="nav-icon fas fa-cogs"></i>
                         <p>
                             Riwayat
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ route('master.barang.index') }}"
                                 class="nav-link {{ $active == 'pesan-barang' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Pesan Barang</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link {{ $active == 'barang-masuk' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Barang Masuk</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link {{ $active == 'barang-keluar' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Barang Keluar</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link {{ $active == 'permintaan-barang' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Permintaan Barang</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item menu-open">
                     <a href="#" class="nav-link {{ $active_group == 'pengelolaan' ? 'active' : '' }}">
                         <i class="nav-icon fas fa-history"></i>
                         <p>
                             Pengelolaan
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ route('master.barang.index') }}"
                                 class="nav-link {{ $active == 'pesan-barang' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Pesan Barang</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link {{ $active == 'barang-masuk' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Barang Masuk</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link {{ $active == 'barang-keluar' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Barang Keluar</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link {{ $active == 'permintaan-barang' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Permintaan Barang</p>
                             </a>
                         </li>
                     </ul>
                 </li>
             </ul>
         </nav>
     </div>
 </aside>
