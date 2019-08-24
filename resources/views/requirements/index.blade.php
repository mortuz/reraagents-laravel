@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Requirements </h3>

    <a href="{{ route('requirement.create') }}" class="btn btn-gradient-primary"><i class="mdi mdi-plus"></i> Add new requirement</a>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Requirements list</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="scope"> ID </th>
                  {{-- <th> State </th> --}}
                  <th> City </th>
                  <th> Price </th>
                  <th> Status </th>
                  <th> Agent </th>
                  <th> Details </th>
                  <th> Working agent </th>
                  <th> Assigned office </th>
                  <th> Call Date </th>
                  <th> Visit Date </th>
                  <th> Customer status </th>
                  <th> Last updated </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>

                @foreach ($requirements as $requirement)
                  <tr>
                    <td>{{ $requirement->id }}{!!$requirement->request_delete ? '<label class="badge badge-danger ml-3">Del</label>' : null !!}</td>
                    {{-- <td>{{ $requirement->state->name }}</td> --}}
                    <td>{{ $requirement->city->name }}</td>
                    <td> {{ $requirement->prices->first() ? $requirement->prices->first()->price : '--'}} </td>
                    <td>
                      @switch($requirement->status)
                        @case(0)
                            <label class="badge badge-dark">New</label>
                            @break
                        @case(1)
                            <label class="badge badge-success">Released</label>
                            @break
                        @case(2)
                            <label class="badge badge-danger">Reject</label>
                            @break
                        @default
                            
                      @endswitch
                    </td>
                    <td>
                      <p>
                        {{ $requirement->user->name }} <br>
                      {{ $requirement->mobile }}
                      </p>
                    </td>
                    <td>{{ json_decode($requirement->raw_data)->details }}</td>
                    <td>
                      @if ($requirement->working_agent > 0)
                        <h3 class="h4">{{ $requirement->workingAgent->user->name }}</h3>
                        <p>
                          {{ $requirement->workingAgent->user->mobile }} <br>
                          {{ $requirement->workingAgent->state->name }} <br>
                          {{ $requirement->workingAgent->city->name }} <br>
                        </p>
                      @else
                        --
                      @endif
                    </td>
                    <td>
                      @if($requirement->office_id > 0)
                        <h5>{{ $requirement->office->name }}</h5>
                        <p>
                          <strong>{{ $requirement->office->mobile }}</strong> <br>
                          {{ $requirement->office->address }}
                        </p>
                      @else
                      @endif
                    </td>
                    <td>{{$requirement->call_date ?? '--'}}</td>
                    <td>{{$requirement->visit_date ?? '--'}}</td>
                    <td>{{$requirement->customerStatus ? $requirement->customerStatus->status : '--' }}</td>
                    <td> {{ $requirement->updated_at->diffForHumans() }} </td>
                    <td>
                      <a href="{{ route('requirement.edit', ['requirement' => $requirement->id]) }}" class="btn btn-gradient-light btn-rounded btn-sm" title="Edit">
                        <i class="mdi mdi-pencil"></i>
                      </a>

                      <button type="button" class="btn btn-gradient-danger btn-rounded btn-sm btn-delete" data-id="{{ $requirement->id }}" data-action="{{ route('requirement.destroy', ['requirement' => $requirement->id]) }}">
                        <i class="mdi mdi-delete"></i>
                      </button>

                    </td>
                  </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="mt-4">
        {{ $requirements->links() }}
      </div>

    </div>
  </div>
  <form autocomplete="off" class="d-none" action="#" method="post" id="delete-form">
    @method('delete')
    @csrf
  </form>
@endsection

@section('javascript')
    <script>
      $('.btn-delete').on('click', function(e) {
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-action');
        swal({
          title: 'Are you sure?',
          text: `Requirement ${id} will be deleted. Would you like to continue?`,
          icon: 'success',
          buttons: {
            cancel: {
              text: "Cancel",
              value: false,
              visible: true,
              className: "btn btn-gradient-danger"
            },
            confirm: {
              text: "Confirm",
              value: true,
              visible: true,
              className: "btn btn-gradient-primary"
            }
          }
        }).then(
          function(confirm) {

            if (confirm) {
              var form = $('#delete-form');
              form.attr('action', url);
              form.submit();
            }
          },
          // handling the promise rejection
          function(dismiss) {
            // console.log('d',dismiss)
          }
        );

      });
    </script>
@endsection