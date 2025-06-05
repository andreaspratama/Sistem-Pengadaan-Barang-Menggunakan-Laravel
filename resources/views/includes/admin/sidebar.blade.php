<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="index.html"><img src="{{url('./belakang/assets/compiled/svg/logo.svg')}}" alt="Logo" srcset=""></a>
                </div>
                <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin logout?')">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                
                <li
                    class="sidebar-item">
                    <a href="#" class='sidebar-link'>
                        <span>{{auth()->user()->name}} <span class="badge bg-primary">{{auth()->user()->role}}</span></span>
                    </a>
                    

                </li>

                <li
                    class="sidebar-item active ">
                    <a href="{{route('dashboard')}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                    

                </li>
                
                @if (in_array(Auth::user()->role, ['Admin', 'Procurement']))
                    <li
                        class="sidebar-item  has-sub">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-stack"></i>
                            <span>Data Master</span>
                        </a>
                        
                        <ul class="submenu ">
                            
                            @if (in_array(Auth::user()->role, ['Admin', 'Procurement']))
                                <li class="submenu-item  ">
                                    <a href="{{route('vendor.index')}}" class="submenu-link">Vendor</a>
                                </li>
                            @endif

                            @if (Auth::user()->role == 'Admin')
                                <li class="submenu-item  ">
                                    <a href="{{route('ta.index')}}" class="submenu-link">Tahun Ajaran</a>
                                </li>

                                <li class="submenu-item  ">
                                    <a href="{{route('kategori.index')}}" class="submenu-link">Kategori</a>
                                </li>
                            @endif
                            
                        </ul>
                        

                    </li>
                @endif

                <li
                    class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-shop"></i>
                        <span>Data Pengajuan Barang</span>
                    </a>
                    
                    <ul class="submenu ">
                        
                        <li class="submenu-item  ">
                            <a href="{{route('pengadaan.index')}}" class="submenu-link">Pengajuan Barang</a>
                            
                        </li>
                        
                    </ul>
                    

                </li>
                @if (in_array(Auth::user()->role, ['Admin', 'Procurement']))
                    <li
                        class="sidebar-item  has-sub">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-bag-heart-fill"></i>
                            <span>Perintah Order</span>
                        </a>
                        
                        <ul class="submenu ">

                            <li class="submenu-item  ">
                                <a href="{{route('perintahorder.index')}}" class="submenu-link">Order</a>
                                
                            </li>
                            
                        </ul>
                        

                    </li>
                @endif

                @if (in_array(Auth::user()->role, ['Admin', 'Procurement']))
                    <li
                        class="sidebar-item  has-sub">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-wallet-fill"></i>
                            <span>Pengajuan Kebutuhan TA</span>
                        </a>
                        
                        <ul class="submenu ">
                            
                            <li class="submenu-item  ">
                                <a href="" class="submenu-link">Pengajuan</a>
                                
                            </li>
                            
                        </ul>
                        

                    </li>
                @endif
                
            </ul>
        </div>
    </div>
</div>