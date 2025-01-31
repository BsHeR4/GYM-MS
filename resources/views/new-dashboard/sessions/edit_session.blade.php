@extends('new-dashboard.layouts.app_dashborad')
@section('title', 'Edit Session')
@section('content')
@extends('components.alert')
<div class="container-xxl flex-grow-1 container-p-y">
  <!-- Basic with Icons -->
  <div class="col-xxl">
    <div class="card mb-6">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Session</h5>
        {{-- <small class="text-muted float-end">Merged input group</small> --}}
      </div>
      <div class="card-body">
        <form action="{{route('sessions.update', $session)}}" method="POST" id="create_session">
          @csrf
          @method('PUT')
          <input type="hidden" name="status" value="active">
          <input type="hidden" name="session_id" value="{{$session->id}}">

          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Session Name</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-dumbbell"></i></span>
                <input name="name" type="text" class="form-control" value="{{$session->name}}" id="basic-icon-default-fullname" placeholder="John" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2">
              </div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Description</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-detail"></i></span>
                <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Type More Information Here ...">{{$session->description}}</textarea>
              </div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Number of members</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="bx bx-group"></i></span>
                <input min="1" type="number" class="form-control" value="{{$session->max_members}}" id="inputNumberofmembers" name="members_number" placeholder="NumberOfMembers">
              </div>
            </div>
          </div>



          <div class="row mb-6">
            <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">Trainer</label>
            <div class="col-sm-10">
              <select name="trainer_id" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option selected>Open To Select A Trainer</option>
                @foreach ($trainers as $trainer)
                <option {{$trainer->id == $session->user_id ? 'selected' : ''}} value="{{$trainer->id}}">{{$trainer->getFullName()}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-6">
            <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">Plans</label>
            <div class="col-sm-10">
              <select name="plan_id" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option selected>Open To Select A Plan</option>
                @foreach ($plans as $plan)
                <option value="{{ $plan->id }}"
                  @if($cur_plan->pluck('id')->contains($plan->id)) selected @endif>
                  {{ $plan->name }}
                </option>
                @endforeach
              </select>
            </div>
          </div>


          <div class="row mb-6">
            <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">Time</label>
            <div class="col-sm-10">
              <select name="time_id" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option selected>Open To Select A Time</option>
                @foreach ($times as $time)
                <option {{$time->id == $session->time_id ? 'selected' : ''}} value="{{$time->id}}">{{$time->day . " At " .$time->getStartAndEndTime12Hours()}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-6">
            <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
              <select name="status" class="form-select" id="nameBasic-{{$session->id}}" aria-label="Default select example">
                <option {{$session->status == 'active' ? 'selected' : ''}} value="active">active</option>
                <option {{$session->status == 'inactive' ? 'selected' : ''}} value="inactive">inactive</option>
                <option {{$session->status == 'completed' ? 'selected' : ''}} value="completed">completed</option>
              </select>
            </div>
          </div>
          <input type="hidden" name="redirect_to" id="redirect_to" value="">
          <div class="row justify-content-end">
            <div class="col-sm-10">
              <button type="submit" id="submit_redirect_index" class="btn btn-primary">Edit</button>
              <a href="{{route('sessions.index')}}" class="btn btn-light">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('submit_redirect_index').addEventListener('click', function(event) {
    document.getElementById('redirect_to').value = 'index';
    document.getElementById('create_user').submit();
  });
  document.getElementById('submit_redirect_create').addEventListener('click', function(event) {
    document.getElementById('redirect_to').value = 'create';
    document.getElementById('create_user').submit();
  });
</script>
@endsection