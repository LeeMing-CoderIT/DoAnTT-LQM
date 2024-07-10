<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" id="side-bar-mode">
    <!-- Brand Logo -->
    <a href="{{route('admin.home')}}" class="brand-link">
        <img src="{{$logo}}" alt="{{$name_website}}" class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{$name_website}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex" title="{{Auth::user()->fullname}}">
            <div class="image">
                <img src="{{Auth::user()->avatar}}" style="height: 2.1rem;" class="img-circle elevation-3" alt="{{Auth::user()->fullname}}">
            </div>
            <div class="info">
                <a href="{{route('admin.info')}}" class="d-block">{{Auth::user()->fullname}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if ($sidebar)
                    @foreach ($sidebar as $item)
                        @if (isset($item['root']) && $item['root'] < \Auth::user()->root)
                            
                        @else
                        <li class="nav-item {{(isset($item['folder']) && isset($folder) && $item['folder'] == $folder)?'menu-open':''}}">
                            <a href="{{$item['link'] ?? '#'}}" class="nav-link {{(isset($item['folder']) && isset($folder) && $item['folder'] == $folder)?'active':''}}">
                                <i class="nav-icon fas {{$item['icon']}}"></i>
                                <p>
                                    {{$item['name']}}
                                    @if (isset($item['items']) && is_array($item['items']) && count($item['items']) > 0)
                                    <i class="fas fa-angle-left right"></i>
                                    @endif
                                </p>
                            </a>
                            @if (isset($item['items']) && is_array($item['items']) && count($item['items']) > 0)
                            <ul class="nav nav-treeview">
                                @foreach ($item['items'] as $value)
                                <li class="nav-item">
                                    <a href="{{$value['link']}}" class="nav-link {{(isset($folder) && isset($path_active) && $value['link']==$path_active)?'active':''}}">
                                        <i class="fas {{$value['icon']}} nav-icon"></i>
                                        <p>{{$value['name']}}</p>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>