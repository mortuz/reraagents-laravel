@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white mr-2">
          <i class="mdi mdi-home"></i>
      </span> Agents
    </h3>

    <a href="{{ route('agents.create') }}" class="btn btn-gradient-primary"><i class="mdi mdi-plus"></i> Add agent</a>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Agents list</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="scope"> ID </th>
                  <th> Name </th>
                  <th> Mobile </th>
                  <th> State </th>
                  <th> City </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>

                @foreach ($agents as $agent)
                  <tr>
                    <td>{{ $agent->user->id }}</td>
                    <td> <strong>{{ $agent->user->name }}</strong> </td>
                    <td> {{ $agent->user->mobile }} </td>
                    <td> {{ $agent->state->name }} </td>
                    <td>{{$agent->city->name}}</td>
                    <td>
                      <a href="{{ route('agents.edit', ['agent' => $agent->id]) }}" class="btn btn-gradient-light btn-rounded btn-sm" title="Edit">
                        <i class="mdi mdi-pencil"></i>
                      </a>

                      {{-- <button type="button" class="btn btn-gradient-danger btn-rounded btn-sm btn-delete" data-name="{{ $agent->user->name }}"
                         data-action="{{ route('agents.destroy', ['agents' => $agent->id]) }}">
                        <i class="mdi mdi-delete"></i>
                      </button> --}}

                    </td>
                  </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="mt-4">
        {{ $agents->links() }}
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
        var name = $(this).attr('data-name');
        var url = $(this).attr('data-action');
        swal({
          title: 'Are you sure?',
          text: `Builder "${name}" will be delete. Would you like to continue?`,
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