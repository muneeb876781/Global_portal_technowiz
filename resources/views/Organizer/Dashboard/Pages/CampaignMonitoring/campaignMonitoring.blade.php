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
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/css/organizer/Login/images/favicon.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/elmma06n570gih5simypugr5mexr6mqv82cnbnodgqcxmpmg/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <title>Applications | Technowiz Admin Console</title>

</head>

<body>
    @include('Organizer.Dashboard.Components.sideNav')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('pause_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Campaign Paused!',
                text: '{{ session('pause_success') }}', // Show the pause success message
                confirmButtonText: 'Close'
            });
        </script>
    @endif

    @if (session('start_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Campaign scheduled!',
                text: '{{ session('start_success') }}', // Show the pause success message
                confirmButtonText: 'Close'
            });
        </script>
    @endif


    <div class="content-start transition">
        <div class="container-fluid dashboard">
            <div class="content-header">
                <h1>Campaign Monitoring</h1>
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
                                        <th class="title">Time Duration</th>
                                        <th class="title">Status</th>
                                        <th class="title">Acquisitions</th> 
                                        <th class="ranking">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $serialNumber = 1; @endphp
                                    @foreach ($campaigns as $campaign)
                                        <tr>
                                            <td style="width: 5%" class="serial-number">{{ $serialNumber++ }}</td>
                                            <td style="width: 10%"><strong>{{ $campaign->name }}</strong></td>
                                            <td style="width: 10%">{{ $campaign->application->name ?? 'App Deleted' }}</td>
                                            <td style="width: 10%">{{ $campaign->source }}</td>
                                            <td style="width: 30%">
                                                <strong>Starts at</strong> {{ \Carbon\Carbon::parse($campaign->starts_at)->format('g:i A') }} <br>
                                                <strong>Pause at</strong> {{ \Carbon\Carbon::parse($campaign->pause_at)->format('g:i A') }}
                                            </td>
                                            <td style="width: 15%">{{ $campaign->status == 1 ? 'Active' : 'Paused' }}</td>
                                            <td style="width: 20%">
                                                <!-- Display the last user count or a message if no data exists -->
                                                @php
                                                    // Get the last entry from the userData related to the campaign
                                                    $lastUserData = $campaign->userData->last();
                                                @endphp
                                            
                                                @if ($lastUserData && $lastUserData->user_count > 0)
                                                    <p> <strong>{{ $lastUserData->user_count }} Acquisitions</strong> in last five minutes</p>
                                                @else
                                                    <p>No Acquisitions</p>
                                                @endif
                                            </td>
                                            
                                            
                                            
                                            <td style="width: 15%">
                                                <div class="tableaction">
                                                    @if ($campaign->status == 1)
                                                        <!-- Pause Button -->
                                                        <form action="{{ route('organizer.campaign.pause', $campaign->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="editbtn">Pause</button>
                                                        </form>
                                                    @else
                                                        <!-- Start Button -->
                                                        <button class="editbtn" onclick="showStartModal({{ $campaign->id }})">Start</button>
                                                    @endif
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

            {{-- Start Pause Modal --}}
            <div id="pauseModal">
                <div>
                    <h3>Enter Start and Pause Times</h3>
                    <label for="startTime">Start Time:</label>
                    <input type="time" id="startTime" required>

                    <label for="pauseTime">Pause Time:</label>
                    <input type="time" id="pauseTime" required>

                    <button onclick="submitStart()">Submit</button>
                    <button onclick="closeModal()">Cancel</button>
                </div>
            </div>
            <div id="modalOverlay" class="modal-overlay"></div>
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

        let currentCampaignId = null; // Variable to hold the current campaign ID

        function showStartModal(campaignId) {
            currentCampaignId = campaignId; // Set the current campaign ID
            document.getElementById('pauseModal').style.display = 'block';
            document.getElementById('modalOverlay').style.display = 'block'; // Show overlay
        }

        function closeModal() {
            document.getElementById('pauseModal').style.display = 'none';
            document.getElementById('modalOverlay').style.display = 'none'; // Hide overlay
        }

        function submitStart() {
            const startTime = document.getElementById('startTime').value;
            const pauseTime = document.getElementById('pauseTime').value;

            // Validate both inputs
            if (!startTime || !pauseTime) {
                alert('Please enter both start and pause times.');
                return;
            }

            // Create a form to submit the start action
            const form = document.createElement('form');
            form.action = `/monitor/${currentCampaignId}/start`; // Use the current campaign ID
            form.method = 'POST';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}'; // Ensure this is accessible in your JS

            const startTimeInput = document.createElement('input');
            startTimeInput.type = 'hidden';
            startTimeInput.name = 'start_time'; // This is the new input for start time
            startTimeInput.value = startTime;

            const pauseTimeInput = document.createElement('input');
            pauseTimeInput.type = 'hidden';
            pauseTimeInput.name = 'pause_time';
            pauseTimeInput.value = pauseTime;

            form.appendChild(csrfInput);
            form.appendChild(startTimeInput);
            form.appendChild(pauseTimeInput);
            document.body.appendChild(form);
            form.submit();

            // Close modal after submission
            closeModal();
        }
    </script>
</body>

</html>
