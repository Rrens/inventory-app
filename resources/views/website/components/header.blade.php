<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <ul class="navbar-nav ml-auto">
        @if (!empty($notificationData))

            <li class="dropdown mr-3">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">{{ count($notificationData) }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                    style="left: inherit; right: 0px; min-width: 900px !important;">
                    <span class="dropdown-item dropdown-header">{{ count($notificationData) }} Notifications</span>
                    @foreach ($notificationData as $item)
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('notification.read', $item->id) }}" class="dropdown-item"
                            style="background-color: {{ $item->is_read ? '#e0e0e0' : '#ffffff' }}">
                            <i class="fas fa-envelope mr-2"></i> {{ $item->title }}
                            <span class="float-right text-muted text-sm">{{ $item->created_at->diffForHumans() }}</span>
                        </a>
                    @endforeach
                </ul>
            </li>
        @endif
        {{-- @dd($notificationData) --}}
        <li class="dropdown user user-menu m-auto">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ auth()->user()->username }}</span>
            </a>
            <ul class="dropdown-menu">
                <li class="user-header">
                    <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

                    <p>
                        <a href="{{ route('logout') }}" class="btn btn-danger btn-flat">Sign out</a>
                    </p>
                </li>
            </ul>
        </li>
    </ul>
</nav>

@push('css')
    <style>
        .dropdown-menu {
            width: auto;
        }
    </style>
@endpush
