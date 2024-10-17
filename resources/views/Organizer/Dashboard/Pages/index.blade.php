<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/bootstrap-5.1.3/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/fontawesome6.1.1/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/apexcharts/apexcharts.css') }}">
    <title>Dashboard | Technowiz Universal Portal</title>
</head>

<body>
    @include('Organizer.Dashboard.Components.sideNav')

    <div class="content-start transition">
        <div class="container-fluid dashboard">
            <div class="content-header">
                <h1>Dashboard</h1>
            </div>

            <div class="dashboardhome">
                <div class="servicecards">
                    <a class="singlecard" href="{{ route('organizer.applications') }}">
                        <img src="{{ asset('assets/css/organizer/Dashboard/images/Services/app.avif') }}"
                            alt="">
                        <h2>Applications</h2>
                    </a>

                    <a class="singlecard" href="{{ route('organizer.BlacklistNumbers') }}">
                        <img src="{{ asset('assets/css/organizer/Dashboard/images/Services/blacklist.avif') }}"
                            alt="">
                        <h2>Black List Number</h2>
                    </a>

                    <a class="singlecard" href="">
                        <img src="{{ asset('assets/css/organizer/Dashboard/images/Services/whitelist.avif') }}"
                            alt="">
                        <h2>White List Number</h2>
                    </a>

                    <a class="singlecard" href="{{ route('organizer.campaignsetup') }}">
                        <img src="{{ asset('assets/css/organizer/Dashboard/images/Services/campaignsetup.avif') }}"
                            alt="">
                        <h2>Campaign Setup</h2>
                    </a>

                    <a class="singlecard"  href="{{ route('organizer.campaignmonituring') }}">
                        <img src="{{ asset('assets/css/organizer/Dashboard/images/Services/campaignmonitor.avif') }}"
                            alt="">
                        <h2>Campaign Monitor</h2>
                    </a>

                    <a class="singlecard" href="{{ route('organizer.apiUrls') }}">
                        <img src="{{ asset('assets/css/organizer/Dashboard/images/Services/api.jpg') }}"
                            alt="">
                        <h2>Api Url'a</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
