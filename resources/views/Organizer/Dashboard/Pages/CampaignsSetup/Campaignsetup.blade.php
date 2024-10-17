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
    <title>Applications | Technowiz Universal Portal</title>
</head>

<body>
    @include('Organizer.Dashboard.Components.sideNav')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Campaign Successfully added!',
                text: '{{ session('success') }}',
                confirmButtonText: 'Close'
            });
        </script>
    @endif
    @if (session('delete_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Campaign Successfully deleted!',
                text: '{{ session('delete_success') }}',
                confirmButtonText: 'Close'
            });
        </script>
    @endif
    @if (session('update_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Campaign Successfully Updated!',
                text: '{{ session('update_success') }}',
                confirmButtonText: 'Close'
            });
        </script>
    @endif
    @if (session('restore_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Campaign Successfully restored!',
                text: '{{ session('restore_success') }}',
                confirmButtonText: 'Close'
            });
        </script>
    @endif

    <div class="content-start transition">
        <div class="container-fluid dashboard">
            <div class="content-header">
                <h1>Campaign Setup</h1>
                <br>
                <button id="showAllCampaign" class="btn btn-primary">ALL Campaigns</button>
                <button id="showAddCampaignFormBtn" class="btn btn-primary">Add Campaign</button>
                <button id="showDeletedCampaigns" class="btn btn-primary">Deleted Campaigns</button>
            </div>

            <div class="col-md-12">
                <div id="allCampaign" class="card">
                    <div class="card-header">
                        <h4>Campaigns</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="CampaignTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="serial-number">No.</th>
                                        <th class="title">Name</th>
                                        <th class="title">App</th>
                                        <th class="title">Source</th>
                                        <th class="title">Starts at</th>
                                        <th class="title">Pause at</th>
                                        {{-- <th class="title">Status</th> --}}
                                        <th class="ranking">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $serialNumber = 1; @endphp
                                    @foreach ($campaigns as $campaign)
                                        <tr>
                                            <td style="width: 10%" class="serial-number">{{ $serialNumber++ }}</td>
                                            <td style="width: 15%"><strong>{{ $campaign->name }}</strong></td>
                                            <td style="width: 15%">{{ $campaign->application->name ?? 'App Deleted' }}
                                            </td>
                                            <td style="width: 15%">{{ $campaign->source }}</td>
                                            <td style="width: 20%">
                                                {{ \Carbon\Carbon::parse($campaign->starts_at)->format('g:i A') }}</td>
                                            <td style="width: 20%">
                                                {{ \Carbon\Carbon::parse($campaign->pause_at)->format('g:i A') }}</td>
                                            {{-- <td style="width: 15%">{{ $campaign->status }}</td> --}}


                                            <td style="width: 20%">
                                                <div class="tableaction">
                                                    <a class="editbtn"
                                                        href="{{ route('organizer.campaign.edit', $campaign->id) }}">Edit</a>

                                                    <!-- Delete Form -->
                                                    <form id="deleteForm"
                                                        action="{{ route('organizer.campaign.destroy', $campaign->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="editbtn"
                                                            onclick="openDeleteModal('{{ $campaign->name }}')">Delete</button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="addCampaignForm" class="row" style="display: none">
                <form class="main_form" action="{{ route('organizer.campaign.store') }}" method="POST"
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
                                            placeholder="Enter Campaign Name" required>
                                    </div>

                                    <!-- Select Application Dropdown -->
                                    <div class="mb-3">
                                        <label for="app_id">Select Application:</label>
                                        <select class="form-control" id="app_id" name="app_id" required>
                                            <option value="" disabled selected>-- Select Application --</option>
                                            @foreach ($applications as $application)
                                                <option value="{{ $application->id }}">{{ $application->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- source --}}
                                    <div class="mb-3">
                                        <label for="source">Select Source:</label>
                                        <select class="form-control" id="source" name="source" required>
                                            <option value="" disabled selected>-- Select Source --</option>
                                            <option value="tnz_gdn">TNZ GDN</option>
                                            <option value="google">Google</option>
                                            <option value="tiktok_tnz">TikTok TNZ</option>
                                            <option value="ndnc">NDNC</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Media Section -->
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4></h4>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label for="threshold">Threshold:</label>
                                        <input class="form-control" type="number" id="threshold" name="threshold" placeholder="Enter Threshold" required>
                                    </div>
                                    <!-- Start Date -->
                                    <div class="mb-3">
                                        <label for="starts_at">Starts At:</label>
                                        <input class="form-control" type="time" id="starts_at" name="starts_at"
                                            required placeholder="Select Start Date">
                                    </div>

                                    <!-- Pause Date -->
                                    <div class="mb-3">
                                        <label for="pause_at">Pause At:</label>
                                        <input class="form-control" type="time" id="pause_at" name="pause_at"
                                            required placeholder="Select Pause Date">
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Add Campaign</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="deletedcamaigns" class="row" style="display: none">
                <div id="deletedCampaigns" class="card">
                    <div class="card-header">
                        <h4>Deleted Campaigns</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="deletedCampaignTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="serial-number">No.</th>
                                        <th class="title">Name</th>
                                        <th class="title">App</th>
                                        <th class="title">Source</th>
                                        <th class="title">Deleted at</th>
                                        {{-- <th class="title">Pause at</th> --}}
                                        <th class="ranking">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $serialNumber = 1; @endphp
                                    @foreach ($deletedCampaigns as $deletedCampaign)
                                        <tr>
                                            <td style="width: 10%" class="serial-number">{{ $serialNumber++ }}</td>
                                            <td style="width: 15%"><strong>{{ $deletedCampaign->name }}</strong></td>
                                            <td style="width: 15%">
                                                {{ $deletedCampaign->application->name ?? 'App Deleted' }}
                                            </td>
                                            <td style="width: 15%">{{ $deletedCampaign->source }}</td>
                                            <td style="width: 20%">
                                                {{ $deletedCampaign->deleted_at }}
                                            </td>
                                            {{-- <td style="width: 20%">
                                                {{ \Carbon\Carbon::parse($deletedCampaign->pause_at)->format('g:i A') }}</td> --}}


                                            <td style="width: 20%">
                                                <div class="tableaction">
                                                    {{-- <a class="editbtn"
                                                        href="{{ route('organizer.campaign.edit', $campaign->id) }}">Edit</a> --}}

                                                    <!-- Delete Form -->
                                                    <form id="restoreForm"
                                                        action="{{ route('organizer.campaign.restore', $deletedCampaign->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        <button type="submit" onclick="return confirmRestore();"
                                                            class="editbtn">Restore</button>
                                                    </form>


                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- deletion model --}}
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeDeleteModal()">&times;</span>
                    <h3>Confirm Campaign Deletion</h3>
                    <p>To delete this campaign, please enter the campaign name: <br>
                        <strong id="campaignNameDisplay"></strong>
                    </p>
                    <input type="text" id="campaignNameInput" placeholder="Enter campaign name"
                        autocomplete="off" class="form-control">
                    <div id="errorMessage" style="color: red;">The campaign name entered does not match!</div>
                    <br>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                </div>
            </div>



        </div>
    </div>




    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var toolsTable = $('#CampaignTable').DataTable({
                "lengthMenu": [5, 10, 25, 50, -1],
                "pageLength": 50,
            });

            // Search input event
            $('#CampaignTable').on('keyup', function() {
                toolsTable.search(this.value).draw();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var toolsTable = $('#deletedCampaignTable').DataTable({
                "lengthMenu": [5, 10, 25, 50, -1],
                "pageLength": 50,
            });

            // Search input event
            $('#deletedCampaignTable').on('keyup', function() {
                toolsTable.search(this.value).draw();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#showAllCampaign').on('click', function() {
                $('#allCampaign').show();
                $('#addCampaignForm').hide();
                $('#deletedcamaigns').hide();
            });

            $('#showAddCampaignFormBtn').on('click', function() {
                $('#allCampaign').hide();
                $('#addCampaignForm').show();
                $('#deletedcamaigns').hide();
            });

            $('#showDeletedCampaigns').on('click', function() {
                $('#allCampaign').hide();
                $('#addCampaignForm').hide();
                $('#deletedcamaigns').show();
            });
        });
    </script>
    <script type="text/javascript">
        function confirmRestore() {
            return confirm('Are you sure you want to Restore this campaign?');
        }
    </script>
    <script>
        // Function to open the modal and set the campaign name
        function openDeleteModal(campaignName) {
            document.getElementById('campaignNameDisplay').innerText = campaignName;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        // Function to close the modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Function to validate the entered name and submit the form
        function confirmDelete() {
            var enteredName = document.getElementById('campaignNameInput').value;
            var campaignName = document.getElementById('campaignNameDisplay').innerText;

            if (enteredName === campaignName) {
                // If the entered name matches, submit the form
                document.getElementById('deleteForm').submit();
            } else {
                // If not, show the error message
                document.getElementById('errorMessage').style.display = 'block';
            }
        }
    </script>


</body>

</html>
