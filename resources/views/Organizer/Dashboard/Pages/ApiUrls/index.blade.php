<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/bootstrap-5.1.3/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/fontawesome6.1.1/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Dashboard/modules/apexcharts/apexcharts.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/elmma06n570gih5simypugr5mexr6mqv82cnbnodgqcxmpmg/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <title>Api Urls | Technowiz Universal Portal</title>
</head>

<body>
    @include('Organizer.Dashboard.Components.sideNav')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Api Url Added!',
                text: '{{ session('success') }}', // Show the pause success message
                confirmButtonText: 'Close'
            });
        </script>
    @endif
    @if (session('delete_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Api Url Deleted!',
                text: '{{ session('delete_success') }}', 
                confirmButtonText: 'Close'
            });
        </script>
    @endif
    @if (session('update_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Api Url Updated!',
                text: '{{ session('update_success') }}', 
                confirmButtonText: 'Close'
            });
        </script>
    @endif



    <div class="content-start transition">
        <div class="container-fluid dashboard">
            <div class="content-header">
                <h1>API Url's </h1><br>
                <button id="showwAllApi" class="btn btn-primary">ALL Api Url's</button>
                <button id="addApi" class="btn btn-primary">Add Api Url</button>
            </div>

            <div class="col-md-12">
                <div id="allApi" class="card">
                    <div class="card-header">
                        <h4>Api Urls</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="apiTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="serial-number">No.</th>
                                        <th class="title">App</th>
                                        <th class="title">Url</th>
                                        <th class="ranking">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $serialNumber = 1; @endphp
                                    @foreach ($apis as $api)
                                        <tr>
                                            <td style="width: 10%" class="serial-number">{{ $serialNumber++ }}</td>
                                            <td style="width: 30%">{{ $api->application->name ?? 'App Deleted' }}
                                            
                                            <td style="width: 30%">{{ $api->api_url }}</td>

                                            <td style="width: 30%">
                                                <div class="tableaction">
                                                    <a class="editbtn"
                                                        href="{{ route('organizer.api.edit', $api->id) }}">Edit</a>

                                                    <!-- Delete Form -->
                                                    <form id="deleteForm"
                                                        action="{{ route('organizer.api.destroy', $api->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="editbtn" type="button" class="\"
                                                            onclick="openDeleteModal('{{ $api->application->name  }}')">Delete</button>
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

            <div id="addapiurlform" class="row" style="display: none">
                <form class="main_form" action="{{ route('organizer.api.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Campaign Information Section -->
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Api Information</h4>
                                </div>
                                <div class="card-body">
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
                                </div>
                            </div>
                        </div>

                        <!-- Media Section -->
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Api Url</h4>
                                </div>
                                <div class="card-body">
                                    <!-- API URL Input -->
                                    <div class="mb-3">
                                        <label for="api_url">API URL:</label>
                                        <input type="text" class="form-control" id="api_url" name="api_url"
                                            placeholder="Enter API URL" required>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Add API URL</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- deletion model --}}
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeDeleteModal()">&times;</span>
                    <h3>Confirm Api Url Deletion</h3>
                    <p>To delete this Api Url, please enter the App name: <br>
                        <strong id="appNameDisplay"></strong>
                    </p>
                    <input type="text" id="appNameInput" placeholder="Enter campaign name" autocomplete="off"
                        class="form-control">
                    <div id="errorMessage" style="color: red;">The App name entered does not match!</div>
                    <br>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                </div>
            </div>


        </div>
    </div>



    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var toolsTable = $('#apiTable').DataTable({
                "lengthMenu": [5, 10, 25, 50, -1],
                "pageLength": 50,
            });

            // Search input event
            $('#apiTable').on('keyup', function() {
                toolsTable.search(this.value).draw();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#showwAllApi').on('click', function() {
                $('#allApi').show();
                $('#addapiurlform').hide();
            });

            $('#addApi').on('click', function() {
                $('#allApi').hide();
                $('#addapiurlform').show();
            });
        });
    </script>
    <script>
        // Function to open the modal and set the campaign name
        function openDeleteModal(appName) {
            document.getElementById('appNameDisplay').innerText = appName;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        // Function to close the modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Function to validate the entered name and submit the form
        function confirmDelete() {
            var enteredName = document.getElementById('appNameInput').value;
            var appName = document.getElementById('appNameDisplay').innerText;

            if (enteredName === appName) {
                // If the entered name matches, submit the form
                document.getElementById('deleteForm').submit();
            } else {
                // If not, show the error message
                document.getElementById('errorMessage').style.display = 'block';
            }
        }
    </script>



</body>
</body>

</html>
