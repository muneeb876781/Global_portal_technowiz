<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/css/organizer/Login/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/bootstrap-5.1.3/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/fontawesome6.1.1/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/apexcharts/apexcharts.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/elmma06n570gih5simypugr5mexr6mqv82cnbnodgqcxmpmg/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <title>Edit Api Urls | Technowiz Admin Console</title>
</head>

<body>
    @include('Organizer.Dashboard.Components.sideNav')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="content-start transition">
        <div class="container-fluid dashboard">
            <div class="content-header">
                <h1>Edit {{ $apiurl->application->name }} API Url's </h1><br>
            </div>

            <div id="editapiurlform" class="row" style="">
                <form class="main_form" action="{{ route('organizer.api.update', $apiurl->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- @method('PUT') <!-- Use PUT method for updating --> --}}
                    <div class="row">
                        <!-- Campaign Information Section -->
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Edit Api Information</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Select Application Dropdown -->
                                    <div class="mb-3">
                                        <label for="app_id">Select Application:</label>
                                        <select class="form-control" id="app_id" name="app_id" required>
                                            <option value="" disabled>-- Select Application --</option>
                                            @foreach ($applications as $application)
                                                <option value="{{ $application->id }}"
                                                    {{ $apiurl->app_id == $application->id ? 'selected' : '' }}>
                                                    {{ $application->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Media Section -->
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Edit Api Url</h4>
                                </div>
                                <div class="card-body">
                                    <!-- API URL Input -->
                                    <div class="mb-3">
                                        <label for="api_url">API URL:</label>
                                        <input type="text" class="form-control" id="api_url" name="api_url"
                                            value="{{ $apiurl->api_url }}" placeholder="Enter API URL" required>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Update API URL</button>
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
