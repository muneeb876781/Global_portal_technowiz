<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/bootstrap-5.1.3/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/fontawesome6.1.1/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/apexcharts/apexcharts.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/css/organizer/Login/images/favicon.png') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/elmma06n570gih5simypugr5mexr6mqv82cnbnodgqcxmpmg/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <title>Edit Application | Technowiz Admin Console</title>
</head>

<body>
    @include('Organizer.Dashboard.Components.sideNav')
    <div class="content-start transition">
        <div class="container-fluid dashboard">
            <div class="content-header">
                <h1>Edit "{{ $application->name }}"</h1>
            </div>

            <div id="addCampaignForm" class="row" style="display: block">
                <form class="main_form" action="{{ route('organizer.application.update', $application->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Application Information Section -->
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Edit Application Information</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Application Name -->
                                    <div class="mb-3">
                                        <label for="ApplicationName">Application Name:</label>
                                        <input class="form-control" type="text" id="ApplicationName"
                                            name="ApplicationName" value="{{ $application->name }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Media Section -->
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Media</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Application Image -->
                                    <div class="mb-3">
                                        <label for="ApplicationImage">Application Image:</label>
                                        <div class="photo">
                                            <input class="form-control" type="file" id="ApplicationImage"
                                                name="ApplicationImage">
                                        </div>
                                        <!-- Display existing image if available -->
                                        @if ($application->image)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/uploads/Apps/' . $application->image) }}"
                                                    alt="Application Image" style="width: 100px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Update Application</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>

</html>
