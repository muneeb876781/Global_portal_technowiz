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
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Application Successfully added!',
                text: '{{ session('success') }}',
                confirmButtonText: 'Close'
            });
        </script>
    @endif
    @if (session('delete_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Application Successfully deleted!',
                text: '{{ session('delete_success') }}',
                confirmButtonText: 'Close'
            });
        </script>
    @endif
    @if (session('update_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Application Successfully updated!',
                text: '{{ session('update_success') }}',
                confirmButtonText: 'Close'
            });
        </script>
    @endif

    <div class="content-start transition">
        <div class="container-fluid dashboard">
            <div class="content-header">
                <h1>Applications</h1>
                <br>
                <button id="showAllApplication" class="btn btn-primary">ALL Applications</button>
                <button id="showAddApplicationFormBtn" class="btn btn-primary">Add Application</button>
            </div>

            <div class="col-md-12">
                <div id="allApplications" class="card">
                    <div class="card-header">
                        <h4>Applications</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="applicationTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="serial-number">No.</th>
                                        <th class="title">Image</th>
                                        <th class="title">Name</th>
                                        <th class="ranking">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $serialNumber = 1; @endphp
                                    @foreach ($applications as $application)
                                        <tr>
                                            <td style="width: 10%" class="serial-number">{{ $serialNumber++ }}</td>
                                            <td style="width: 30%"><img style="width: 100px; height: auto;"
                                                    src="{{ asset('storage/uploads/Apps/' . $application->image) }}"
                                                    alt="{{ $application->name }}" ></td>
                                            <td style="width: 30%"><strong>{{ $application->name }}</strong> <br>
                                            </td>
                                            <td style="width: 30%">
                                                <div class="tableaction">
                                                    <a class="editbtn" href="{{ route('organizer.application.edit', $application->id) }}">Edit</a>
                                                    <!-- Delete Form -->
                                                    <form
                                                        action="{{ route('organizer.application.destroy', $application->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirmDelete();">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="editbtn">Delete</button>
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

            <div id="addApplicationForm" class="row" style="display: none">
                <form class="main_form" action="{{ route('organizer.applications.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Information</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Form fields for Product 1 -->
                                    <div class="mb-3">
                                        <label for="ApplicationName">Application Name:</label>
                                        <input class="form-control" type="text" id="ApplicationName"
                                            name="ApplicationName" placeholder="Enter Application Name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Media</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="ApplicationImage">Application Image:</label>
                                        <dic class="photo">
                                            <input class="form-control" style="border: none" type="file"
                                                id="ApplicationImage" name="ApplicationImage">
                                        </dic>
                                        <br>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">Add Application</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>



    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var toolsTable = $('#applicationTable').DataTable({
                "lengthMenu": [5, 10, 25, 50, -1],
                "pageLength": 50,
            });

            // Search input event
            $('#applicationTable').on('keyup', function() {
                toolsTable.search(this.value).draw();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#showAllApplication').on('click', function() {
                $('#allApplications').show();
                $('#addApplicationForm').hide();
            });

            $('#showAddApplicationFormBtn').on('click', function() {
                $('#allApplications').hide();
                $('#addApplicationForm').show();
            });
        });
    </script>
    <script type="text/javascript">
        function confirmDelete() {
            return confirm('Are you sure you want to delete this campaign? This action cannot be undone.');
        }
    </script>
</body>

</html>
