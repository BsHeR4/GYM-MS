@extends('new-dashboard.layouts.app_dashborad')
@section('title', 'Plan Types')
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
           <li class="breadcrumb-item active">Plan Types</li>
        </ol>
      </nav>
    </div>

    <!-- Filter Button -->
    <div class="col-md-4 d-flex justify-content-end align-items-center">
      <a class="btn btn-primary me-1" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        Filter
      </a>

      <!-- Create User -->
      <a class="btn btn-primary me-1" href="{{route('plan_types.create')}}" role="button">
        Create New Plan Type
      </a>
    </div>
  </div>
  
<!-- Filter Content -->
<div class="collapse" id="collapseExample">
  <div class="d-flex p-4">
    <div class="card mb-6 w-100">
      <h4 class="card-header">Filter</h4>
      <form id="FilterForm" action="{{ route('plan_types.index') }}" method="GET">
        <div class="card-body">
          <div class="row mb-3 d-flex align-items-center">
            <!-- Search -->
            <div class="col-sm-4 d-flex align-items-center">
              <label class="col-form-label me-2" for="basic-icon-default-fullname2">Search</label>
              <div class="input-group input-group-merge flex-grow-1">
                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-search"></i></span>
                <input name="name" value="{{request('name')}}" type="text" class="form-control" id="basic-icon-default-fullname2" placeholder="Search Something" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2">
              </div>
            </div>

            <!-- Entries Number Dropdown -->
            <div class="col-sm-2 d-flex align-items-center">
              <input type="hidden" name="entries_number" value="{{request('entries_number')}}" id="entries_number">
              <div class="btn-group me-2">
                <button class="btn btn-primary dropdown-toggle" type="button" id="entriesDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Entries Number
                </button>
                <ul class="dropdown-menu" aria-labelledby="entriesDropdown">
                  <li><a class="dropdown-item {{request('entries_number') == 5 ? 'active' : ''}}" href="javascript:void(0);" onclick="selectEntries('5')">5</a></li>
                  <li><a class="dropdown-item {{request('entries_number') == 10 ? 'active' : ''}}" href="javascript:void(0);" onclick="selectEntries('10')">10</a></li>
                  <li><a class="dropdown-item {{request('entries_number') == 15 ? 'active' : ''}}" href="javascript:void(0);" onclick="selectEntries('15')">15</a></li>
                  <li><a class="dropdown-item {{request('entries_number') == 20 ? 'active' : ''}}"  href="javascript:void(0);" onclick="selectEntries('20')">20</a></li>
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
              <th style="width: 40%">ID</th>
              <th style="width: 40%">Name</th>
              <th style="width: 20%">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($plan_types as $plan_type)
              <tr>
                <td><i class="fab fa-angular fa-xl text-danger me-4"></i> <span>{{$plan_type->id}}</span></td>
                <td>{{$plan_type->name}}</td>
                </td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{route('plan_types.show',$plan_type)}}"><i class="bx bx-show me-1"></i>Show</a>
                      <a class="dropdown-item" href="{{route('plan_types.edit',$plan_type)}}"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('remove_plan_type_{{$plan_type->id}}').submit();"><i class="bx bx-trash me-1"></i>
                          <form id="remove_plan_type_{{$plan_type->id}}" action="{{ route('plan_types.destroy', $plan_type) }}" method="POST" style="display: none;">
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
              <li class="page-item {{ $plan_types->onFirstPage() ? 'disabled' : '' }}">
                  <a class="page-link" href="{{ $plan_types->previousPageUrl() }}">
                      <i class="tf-icon bx bx-chevrons-left bx-sm"></i>
                  </a>
              </li>
      
              <!-- Pagination Links -->
              @for ($i = 1; $i <= $plan_types->lastPage(); $i++)
                  <li class="page-item {{ $plan_types->currentPage() == $i ? 'active' : '' }}">
                      <a class="page-link" href="{{ $plan_types->url($i) }}">
                          {{ $i }}
                      </a>
                  </li>
              @endfor
      
              <!-- Next Page Link -->
              <li class="page-item {{ $plan_types->hasMorePages() ? '' : 'disabled' }}">
                  <a class="page-link" href="{{ $plan_types->nextPageUrl() }}">
                      <i class="tf-icon bx bx-chevrons-right bx-sm"></i>
                  </a>
              </li>
          </ul>
      </nav>
      
        
        
      </div>
</div>
<script>
   function selectPlanType(value) {
        document.getElementById('plan_type').value = value;
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