<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/css/dashboard.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/css/organizer/Dashboard/modules/bootstrap-5.1.3/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/fontawesome6.1.1/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/apexcharts/apexcharts.css') }}">
    <title></title>
</head>

<body>

    <div class="topbar transition">
        <div class="bars">
            <button type="button" class="btn transition" id="sidebar-toggle">
                <i class="fa fa-bars"></i>
            </button>
        </div>

        <div class="menu">
            <ul>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="{{ asset('assets/css/organizer/Dashboard/images/Profile/profileavatar.png') }}"
                            alt="">
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <li>
                            {{-- <form action="" method="post"
                                onsubmit="return confirm('Are you sure you want to delete your store? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dd-item"><i class="fa fa-cog size-icon-1"></i>
                                    <span>Delete</span></button>
                            </form> --}}
                        </li>
                        <li>
                            <form method="POST" action="{{ route('organizer.logout') }}">
                                @csrf
                                <button class="dd-item" type="submit"><i class="fa fa-sign-out-alt  size-icon-1"></i>
                                    <span>Log out</span></button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <!--Sidebar-->
        <div class="sidebar transition overlay-scrollbars animate__animated  animate__slideInLeft">
            <div class="sidebar-content">
                <div id="sidebar">

                    <!-- Logo -->
                    <div class="profileinfo">
                        <img src="{{ asset('assets/css/organizer/Dashboard/images/Profile/profileavatar.png') }}"
                            alt="">
                        <h1 class="profilename">{{ auth()->guard('organizer')->user()->username }}</h1>
                        <form method="POST" action="{{ route('organizer.logout') }}">
                            @csrf
                            <button class="profilelogoutbtn" type="submit"><i
                                    class="fa fa-sign-out-alt  size-icon-1"></i>
                                <span>Log out</span></button>
                        </form>
                    </div>

                    <ul class="side-menu">
                        <li>
                            <a href="{{ route('organizer.dashboard') }}"
                                class="{{ Request::is('dashboard') ? 'active' : '' }}">
                                <i class='bx bxs-home icon'></i>Dashboard
                            </a>

                            <a href="{{ route('organizer.applications') }}"
                                class="{{ Request::is('applications') ? 'active' : '' }}">
                                <i class='bx bxs-file icon'></i>Applications
                            </a>

                            <a href="{{ route('organizer.BlacklistNumbers') }}"
                                class="{{ Request::is('BlacklistNumbers') ? 'active' : '' }}">
                                <i class='bx bxs-file icon'></i>Black List Numbers 
                            </a>

                            <a href="{{ route('organizer.campaignsetup') }}"
                                class="{{ Request::is('campaigns') ? 'active' : '' }}">
                                <i class='bx bxs-file icon'></i>Campaign Setup
                            </a>

                            <a href="{{ route('organizer.campaignmonituring') }}"
                                class="{{ Request::is('monitor') ? 'active' : '' }}">
                                <i class='bx bxs-file icon'></i>Campaign Monitoring
                            </a>

                            <a href="{{ route('organizer.apiUrls') }}"
                                class="{{ Request::is('apiUrls') ? 'active' : '' }}">
                                <i class='bx bxs-file icon'></i>Api Url's
                            </a>


                        </li>
                </div>
            </div>
        </div>
    </div><!-- End Sidebar-->



    <!-- Preloader -->
    <div class="loader">
        <div class="spinner-border text-light" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Loader -->
    <div class="loader-overlay"></div>




    <script>
        $(document).ready(function() {
            // Add 'active' class to the current menu item based on URL
            var currentUrl = window.location.pathname;
            $('.side-menu li a').each(function() {
                var href = $(this).attr('href');
                if (currentUrl === href) {
                    $('.side-menu li a').removeClass('active');
                    $(this).addClass('active');
                }
            });
        });
    </script>

    <!-- General JS Scripts -->
    <script src="{{ asset('../assets/css/organizer/Dashboard/js/atrana.js') }}"></script>
    <script src="{{ asset('../assets/css/organizer/Dashboard/modules/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('../assets/css/organizer/Dashboard/modules/bootstrap-5.1.3/js/bootstrap.bundle.min.js') }}">
    </script>
    <script src="{{ asset('../assets/css/organizer/Dashboard/modules/popper/popper.min.js') }}"></script>
    <script src="{{ asset('../assets/css/organizer/Dashboard/modules/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('../assets/css/organizer/Dashboard/js/ui-apexcharts.js') }}"></script>
    <script src="{{ asset('../assets/css/organizer/Dashboard/js/script.js') }}"></script>
    <script src="{{ asset('../assets/css/organizer/Dashboard/js/custom.js') }}"></script>
</body>

</html>
