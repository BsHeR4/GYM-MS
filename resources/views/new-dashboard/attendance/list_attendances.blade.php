@extends('new-dashboard.layouts.app_dashborad')
@section('title', 'Attendance')
@section('content')
@extends('components.alert')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row mb-3">
    <!-- Breadcrumb -->
    <div class="col-md-8">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Attendances</li>
        </ol>
      </nav>
    </div>

    <!-- Filter Button -->
    <div class="col-md-4 d-flex justify-content-end align-items-center">
      <a class="btn btn-primary me-1" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        Filter
      </a>
  
    </div>
  </div>
  
<!-- Filter Content -->
<div class="collapse" id="collapseExample">
  <div class="d-flex p-4">
    <div class="card mb-6 w-100">
      <h4 class="card-header">Filter</h4>
      <form id="FilterForm" action="{{ route('users.index') }}" method="GET">
        <div class="card-body">
          <div class="row mb-3 d-flex align-items-center">
            <!-- Search -->
            <div class="col-sm-4 d-flex align-items-center">
              <label class="col-form-label me-2" for="basic-icon-default-fullname2">Search</label>
              <div class="input-group input-group-merge flex-grow-1">
                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-search"></i></span>
                <input name="name" type="text" class="form-control" id="basic-icon-default-fullname2" placeholder="Search Something" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2">
              </div>
            </div>

            <!-- Entries Number Dropdown -->
            <div class="col-sm-2 d-flex align-items-center">
              <input type="hidden" name="entries_number" id="entries_number">
              <div class="btn-group me-2">
                <button class="btn btn-primary dropdown-toggle" type="button" id="entriesDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Entries Number
                </button>
                <ul class="dropdown-menu" aria-labelledby="entriesDropdown">
                  <li><a class="dropdown-item" href="javascript:void(0);" onclick="selectEntries('5')">5</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);" onclick="selectEntries('10')">10</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);" onclick="selectEntries('15')">15</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);" onclick="selectEntries('20')">20</a></li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Apply Button -->
          <div class="row">
            <div class="col-sm-12 d-flex justify-content-end">
              <button class="btn btn-light me-1" onclick="resetFilters()">Reset</button>
              <button class="btn btn-primary me-1">APPLY</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

  
  
    <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
                <th>Member Name</th>
                <th>Session Name</th>
                <th>Session Date</th>
                <th>Session Time</th>
                <th> Status</th>
                <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($attendances as $attendance)
            <tr>
                <!-- اسم العضو -->
                <td>{{ $attendance->appointment->user->getFullName() }}</td>

                <!-- اسم الجلسة -->
                <td>{{ $attendance->appointment->session->name }}</td>
                <!-- وقت الجلسة -->
                <td>
                    @if ($attendance->appointment->session->time)
                    {{ $attendance->appointment->session->time->day }}
                    @else
                    <p>No times available</p>
                    @endif
                </td>
                <!-- وقت الجلسة -->
                <td>
                    @if ($attendance->appointment->session->time)
                    {{ $attendance->appointment->session->time->start_time }} - {{ $attendance->appointment->session->time->end_time }}
                    @else
                    <p>No times available</p>
                    @endif
                </td>

                <td>
                    @if($attendance?->status == 'nnconfirmed' )
                    <a href="/attendance/{{$attendance->appointment->id}}/1"><button class="btn btn-success btn-sm accept">Present</button></a>
                    <a href="/attendance/{{$attendance->appointment->id}}/0"><button class="btn btn-danger btn-sm reject"> Absent</button></a>
                    @endif

                    @if($attendance?->status == 'present' )
                    <button class="btn btn-success btn-sm accept">Present</button>
                    @endif

                    @if($attendance?->status == 'absent' )
                    <button class="btn btn-danger btn-sm reject"> Absent</button>
                    @endif
                </td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/attendance/{{$attendance->appointment->id}}/3"><i class="bx bx-show me-1"></i>Reset</a>

                        <a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('Delete_Attendance_{{$attendance->appointment->id}}').submit();"><i class="bx bx-trash me-1"></i>
                            <form id="Delete_Attendance_{{$attendance->appointment->id}}" action="{{ route('attendance.destroy', $attendance->appointment) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            Delete
                        </a>
                        
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center">
            <!-- Previous Page Link -->
            <li class="page-item {{ $attendances->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $attendances->appends(['entries_number' => request('entries_number'), 'searched_name' => request('searched_name'), 'role' => request('role')])->previousPageUrl() }}">
                <i class="tf-icon bx bx-chevrons-left bx-sm"></i>
              </a>
            </li>
        
            <!-- Pagination Links -->
            @for ($i = 1; $i <= $attendances->lastPage(); $i++)
              <li class="page-item {{ $attendances->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $attendances->appends(['entries_number' => request('entries_number'), 'searched_name' => request('searched_name'), 'role' => request('role')])->url($i) }}">
                  {{ $i }}
                </a>
              </li>
            @endfor
        
            <!-- Next Page Link -->
            <li class="page-item {{ $attendances->hasMorePages() ? '' : 'disabled' }}">
              <a class="page-link" href="{{ $attendances->appends(['entries_number' => request('entries_number'), 'searched_name' => request('searched_name'), 'role' => request('role')])->nextPageUrl() }}">
                <i class="tf-icon bx bx-chevrons-right bx-sm"></i>
              </a>
            </li>
          </ul>
        </nav>
        
      </div>
</div>
<script>
  function selectRole(value) {
    document.getElementById('role').value = value;
  }

  function selectEntries(value) {
    document.getElementById('entries_number').value = value;
  }

  function resetFilters() {

    // Get the filter form
    var form = document.getElementById('FilterForm');

    // Clear all input fields
      var inputs = form.getElementsByTagName('input');

      for (var i = 0; i < inputs.length; i++)
      {
          inputs[i].value = ''; 
      }

      // Reload the page without any query parameters
      window.location.href = form.action;
}
</script>
@endsection