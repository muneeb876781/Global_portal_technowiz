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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/elmma06n570gih5simypugr5mexr6mqv82cnbnodgqcxmpmg/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <title>Edit Campaign | Technowiz Universal Portal</title>
</head>

<body>
    @include('Organizer.Dashboard.Components.sideNav')
    <div class="content-start transition">
        <div class="container-fluid dashboard">
            <div class="content-header">
                <h1>Edit "{{ $campaign->name }}"</h1>
            </div>

            <div id="addCampaignForm" class="row" style="display: block">
                <form action="{{ route('organizer.campaign.update', $campaign->id) }}" method="POST">
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Campaign Information Section -->
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Campaign Information</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Campaign Name -->
                                    <div class="mb-3">
                                        <label for="campaignname">Campaign Name:</label>
                                        <input class="form-control" type="text" id="campaignname" name="campaignname"
                                            value="{{ old('campaignname', $campaign->name) }}" required>
                                    </div>

                                    <!-- Select Application Dropdown -->
                                    <div class="mb-3">
                                        <label for="app_id">Select Application:</label>
                                        <select class="form-control" id="app_id" name="app_id" required>
                                            <option value="" disabled>-- Select Application --</option>
                                            @foreach ($applications as $application)
                                                <option value="{{ $application->id }}"
                                                    {{ $campaign->app_id == $application->id ? 'selected' : '' }}>
                                                    {{ $application->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Source Dropdown -->
                                    <div class="mb-3">
                                        <label for="source">Source:</label>
                                        <select class="form-control" id="source" name="source" required>
                                            <option value="tnz_gdn"
                                                {{ $campaign->source == 'tnz_gdn' ? 'selected' : '' }}>TNZ GDN</option>
                                            <option value="google"
                                                {{ $campaign->source == 'google' ? 'selected' : '' }}>Google</option>
                                            <option value="tiktok_tnz"
                                                {{ $campaign->source == 'tiktok_tnz' ? 'selected' : '' }}>Tiktok TNZ
                                            </option>
                                            <option value="ndnc" {{ $campaign->source == 'ndnc' ? 'selected' : '' }}>
                                                NDNC</option>
                                        </select>
                                    </div>

                                    <!-- Start Time -->
                                    <div class="mb-3">
                                        <label for="starts_at">Starts At:</label>
                                        <input class="form-control" type="time" id="starts_at" name="starts_at"
                                            value="{{ old('starts_at', $campaign->starts_at ? date('H:i', strtotime($campaign->starts_at)) : '') }}">
                                    </div>

                                    <!-- Pause Time -->
                                    <div class="mb-3">
                                        <label for="pause_at">Pause At:</label>
                                        <input class="form-control" type="time" id="pause_at" name="pause_at"
                                            value="{{ old('pause_at', $campaign->pause_at ? date('H:i', strtotime($campaign->pause_at)) : '') }}">
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
                                    <!-- Add any media-related fields here if required -->
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Update Campaign</button>
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
