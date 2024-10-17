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
    <title>Black List Numbers | Technowiz Admin Console</title>
</head>

<body>
    @include('Organizer.Dashboard.Components.sideNav')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Number Black Lissted Successfully!',
                text: '{{ session('success') }}',
                confirmButtonText: 'Close'
            });
        </script>
    @endif
    @if (session('blacklisted_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Phone number is already blacklisted!',
                text: '{{ session('blacklisted_success') }}',
                confirmButtonText: 'Close'
            });
        </script>
    @endif
    @if (session('unlock_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Phone number unblocked successfully!',
                text: '{{ session('unlock_success') }}',
                confirmButtonText: 'Close'
            });
        </script>
    @endif


    <div class="content-start transition">
        <div class="container-fluid dashboard">
            <div class="content-header">
                <h1>Black List Numbers </h1><br>
                <button id="showAllBlaclistedNumbers" class="btn btn-primary">ALL Black Listed Numbers</button>
                <button id="addNewBlacklistedNumer" class="btn btn-primary">Add New Number</button>
                <button id="showAllUnblockedNumbers" class="btn btn-primary">All UnBlocked Numbers</button>
            </div>

            <div class="col-md-12">
                <div id="allBlacklistedNumbers" class="card">
                    <div class="card-header">
                        <h4>Blacklisted Numbers</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="blacklistedTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="serial-number">No.</th>
                                        <th class="phone-number">Phone Number</th>
                                        <th class="app-name">App Name</th>
                                        <th class="reason">Reason</th>
                                        <th class="status">Status</th>
                                        <th class="actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $serialNumber = 1; @endphp
                                    @foreach ($blacklistedNumbers as $blacklistedNumber)
                                        <tr>
                                            <td style="width: 5%;" class="serial-number">{{ $serialNumber++ }}</td>
                                            <td style="width: 15%;" class="phone-number">
                                                {{ $blacklistedNumber->phone_number }}</td>
                                            <td style="width: 10%;" class="app-name">
                                                {{ $blacklistedNumber->campaignApi->application->name ?? 'App Deleted' }}
                                            </td>
                                            <td style="width: 20%;" class="reason">
                                                {{ $blacklistedNumber->reason ?? 'No reason provided' }}
                                            </td>
                                            <td style="width: 30%;" class="status">
                                                @if ($blacklistedNumber->is_blocked)
                                                    <span class="">Blocked</span><br>
                                                    <span>Blocked at:
                                                        {{ $blacklistedNumber->blocked_at ? $blacklistedNumber->updated_at->setTimezone('Asia/Karachi')->format('Y-m-d H:i:s') : 'N/A' }}
                                                    </span>
                                                @else
                                                    <span class="">Unblocked</span><br>
                                                    <span>Unblocked at:
                                                        {{ $blacklistedNumber->unblocked_at ? $blacklistedNumber->updated_at->setTimezone('Asia/Karachi')->format('Y-m-d H:i:s') : 'N/A' }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td style="width: 20%;" class="actions">
                                                <div class="tableaction">
                                                    @if ($blacklistedNumber->is_blocked)
                                                        <form method="POST"
                                                            action="{{ route('organizer.blacklist.unblock', $blacklistedNumber->phone_number) }}"
                                                            style="display:inline-block;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="editbtn">Unblock</button>
                                                        </form>
                                                    @else
                                                        <form method="POST"
                                                            action="{{ route('organizer.blacklist.blockAgain', $blacklistedNumber->phone_number) }}"
                                                            style="display:inline-block;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="editbtn">Block Again</button>
                                                        </form>
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

            <!-- Form for Adding New Blacklisted Number -->
            <div id="addBlacklistForm" class="row" style="display: none">
                <form class="main_form" action="{{ route('organizer.blacklist.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Phone Number Section -->
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Blacklisted Number Information</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Phone Number Input -->
                                    <div class="mb-3">
                                        <label for="phone_number">Phone Number:</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                            placeholder="92xxxxxxxxxx" required pattern="92[0-9]{10}">
                                        <small class="text-muted">Format: 92xxxxxxxxxx (12 digits total)</small>
                                    </div>

                                    <!-- Multi-select Checkbox Dropdown for Applications -->
                                    <div class="mb-3">
                                        <label for="app_id">Select Applications:</label>
                                        <div>
                                            @foreach ($applications as $application)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="app_ids[]"
                                                        value="{{ $application->id }}"
                                                        id="app_{{ $application->id }}">
                                                    <label class="form-check-label" for="app_{{ $application->id }}">
                                                        {{ $application->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reason Section -->
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4></h4>
                                </div>
                                <div class="card-body">
                                    <!-- Blacklisted By Section -->
                                    <div class="mb-3">
                                        <label for="blacklisted_by">Username:</label>
                                        <input type="text" class="form-control" id="blacklisted_by"
                                            name="blacklisted_by" placeholder="Enter username" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="reason">Reason (Optional):</label>
                                        <textarea class="form-control" id="reason" name="reason" rows="3"
                                            placeholder="Enter reason for blacklisting"></textarea>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Add Blacklisted Number</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="unblockedNumbers" class="row" style="display: none">
                <div id="unblockedNumbers" class="card">
                    <div class="card-header">
                        <h4>Deleted Campaigns</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="unBlockedtable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="serial-number">No.</th>
                                        <th class="phone-number">Phone Number</th>
                                        <th class="app-name">App Name</th>
                                        <th class="reason">Reason</th>
                                        <th class="status">Status</th>
                                        <th class="actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $serialNumber = 1; @endphp
                                    @foreach ($unBlockedNumbers as $unBlockedNumber)
                                        <tr>
                                            <td style="width: 5%;" class="serial-number">{{ $serialNumber++ }}</td>
                                            <td style="width: 15%;" class="phone-number">
                                                {{ $unBlockedNumber->phone_number }}</td>
                                            <td style="width: 10%;" class="app-name">
                                                {{ $unBlockedNumber->campaignApi->application->name ?? 'App Deleted' }}
                                            </td>
                                            <td style="width: 20%;" class="reason">
                                                {{ $unBlockedNumber->reason ?? 'No reason provided' }}
                                            </td>
                                            <td style="width: 30%;" class="status">
                                                @if ($unBlockedNumber->is_blocked)
                                                    <span class="">Blocked</span><br>
                                                    <span>Blocked at:
                                                        {{ $unBlockedNumber->blocked_at ? $unBlockedNumber->updated_at->setTimezone('Asia/Karachi')->format('Y-m-d H:i:s') : 'N/A' }}
                                                    </span>
                                                @else
                                                    <span class="">Unblocked</span><br>
                                                    <span>Unblocked at:
                                                        {{ $unBlockedNumber->unblocked_at ? $unBlockedNumber->updated_at->setTimezone('Asia/Karachi')->format('Y-m-d H:i:s') : 'N/A' }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td style="width: 20%;" class="actions">
                                                <div class="tableaction">
                                                    {{-- @if ($unBlockedNumber->is_blocked)
                                                        <form method="POST"
                                                            action="{{ route('organizer.blacklist.unblock', $unBlockedNumber->phone_number) }}"
                                                            style="display:inline-block;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="editbtn">Unblock</button>
                                                        </form>
                                                    @else
                                                        <form method="POST"
                                                            action="{{ route('organizer.blacklist.blockAgain', $unBlockedNumber->phone_number) }}"
                                                            style="display:inline-block;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="editbtn">Block Again</button>
                                                        </form>
                                                    @endif --}}
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

        </div>
    </div>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var toolsTable = $('#blacklistedTable').DataTable({
                "lengthMenu": [5, 10, 25, 50, -1],
                "pageLength": 50,
            });

            // Search input event
            $('#blacklistedTable').on('keyup', function() {
                toolsTable.search(this.value).draw();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var toolsTable = $('#unBlockedtable').DataTable({
                "lengthMenu": [5, 10, 25, 50, -1],
                "pageLength": 50,
            });

            // Search input event
            $('#unBlockedtable').on('keyup', function() {
                toolsTable.search(this.value).draw();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#showAllBlaclistedNumbers').on('click', function() {
                $('#allBlacklistedNumbers').show();
                $('#addBlacklistForm').hide();
                $('#unblockedNumbers').hide();
            });

            $('#addNewBlacklistedNumer').on('click', function() {
                $('#allBlacklistedNumbers').hide();
                $('#addBlacklistForm').show();
                $('#unblockedNumbers').hide();
            });

            $('#showAllUnblockedNumbers').on('click', function() {
                $('#allBlacklistedNumbers').hide();
                $('#addBlacklistForm').hide();
                $('#unblockedNumbers').show();
            });
        });
    </script>


</body>

</html>
