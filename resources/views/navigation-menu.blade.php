<div class="account-nav-wrapper">
    <div class="dropdown user-account-dropdown">
        <button
            class="btn user-account-btn dropdown-toggle"
            type="button"
            id="userAccountDropdown"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <img
                    src="{{ Auth::user()->profile_photo_url }}"
                    alt="{{ Auth::user()->name }}"
                    class="user-avatar"
                >
            @else
                <span class="user-avatar-icon">
                    <i class="fa fa-user"></i>
                </span>
            @endif

            <span class="user-name-text">{{ Auth::user()->name }}</span>
        </button>

        <div class="dropdown-menu dropdown-menu-right user-account-menu" aria-labelledby="userAccountDropdown">
            <div class="account-menu-header">
                <div class="account-menu-name">{{ Auth::user()->name }}</div>
                <div class="account-menu-email">{{ Auth::user()->email }}</div>
            </div>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item account-menu-item" href="{{ route('user.profile') }}">
                <i class="fa fa-user-circle"></i>
                <span>My Profile</span>
            </a>

            <a class="dropdown-item account-menu-item" href="{{ url('/my-order') }}">
                <i class="fa fa-list-alt"></i>
                <span>My Orders</span>
            </a>

            <a class="dropdown-item account-menu-item" href="{{ url('/cart') }}">
                <i class="fa fa-shopping-cart"></i>
                <span>My Cart</span>
            </a>

            <div class="dropdown-divider"></div>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="dropdown-item account-menu-item logout-item">
                    <i class="fa fa-sign-out"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .account-nav-wrapper{
        display:flex;
        align-items:center;
    }

    .user-account-dropdown{
        position:relative;
    }

    .user-account-btn{
        display:inline-flex;
        align-items:center;
        gap:10px;
        border:none;
        background:linear-gradient(135deg, #fff3eb, #fff8f3);
        color:#e65c00;
        padding:8px 14px;
        border-radius:999px;
        font-weight:600;
        box-shadow:0 8px 20px rgba(230,92,0,0.10);
        transition:all 0.25s ease;
    }

    .user-account-btn:hover,
    .user-account-btn:focus{
        background:linear-gradient(135deg, #ffe7d6, #fff3eb);
        color:#c94f00;
        outline:none;
        box-shadow:0 10px 24px rgba(230,92,0,0.16);
    }

    .user-avatar{
        width:34px;
        height:34px;
        border-radius:50%;
        object-fit:cover;
        border:2px solid #ffd7bf;
    }

    .user-avatar-icon{
        width:34px;
        height:34px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#ff6b00;
        color:#fff;
        font-size:14px;
    }

    .user-name-text{
        max-width:120px;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        font-size:14px;
    }

    .user-account-menu{
        min-width:260px;
        border:none;
        border-radius:18px;
        padding:10px;
        margin-top:12px;
        box-shadow:0 20px 40px rgba(0,0,0,0.12);
    }

    .account-menu-header{
        padding:10px 12px 8px;
    }

    .account-menu-name{
        font-size:15px;
        font-weight:700;
        color:#1f2937;
        line-height:1.2;
    }

    .account-menu-email{
        font-size:12px;
        color:#6b7280;
        margin-top:4px;
        word-break:break-word;
    }

    .account-menu-item{
        display:flex;
        align-items:center;
        gap:10px;
        border-radius:12px;
        padding:10px 12px;
        font-size:14px;
        font-weight:600;
        color:#374151;
        transition:all 0.2s ease;
    }

    .account-menu-item i{
        width:18px;
        text-align:center;
        color:#ff6b00;
    }

    .account-menu-item:hover{
        background:#fff3eb;
        color:#e65c00;
    }

    .logout-form{
        margin:0;
    }

    .logout-form button{
        width:100%;
        border:none;
        background:transparent;
        text-align:left;
        cursor:pointer;
    }

    .logout-item{
        color:#c62828;
    }

    .logout-item i{
        color:#c62828;
    }

    .logout-item:hover{
        background:#fff1f1;
        color:#b71c1c;
    }

    @media (max-width: 767px){
        .user-name-text{
            max-width:80px;
            font-size:13px;
        }

        .user-account-menu{
            min-width:220px;
            right:0 !important;
            left:auto !important;
        }
    }
</style>
