@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Finance applications </h3>

    {{-- <a href="{{ route('face.create') }}" class="btn btn-gradient-primary"><i class="mdi mdi-plus"></i> Add Property Facing</a> --}}
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">List of all applications</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="scope"> ID </th>
                  <th> Name </th>
                  <th> Contact </th>
                  <th> City </th>
                  <th> Purpose </th>
                  <th> Description </th>
                </tr>
              </thead>
              <tbody>

                @foreach ($applications as $application)
                  <tr>
                    <td>{{ $application->id }}</td>
                    <td> <strong>{{ $application->name }}</strong> </td>
                    <td> <strong>{{ $application->contact }}</strong> </td>
                    <td> <strong>{{ $application->city->name }}</strong> </td>
                    <td> {{ $application->purpose->purpose }} </td>
                    <td> {{ $application->description }} </td>
                    {{-- <td>
                      <a href="{{ route('face.edit', ['property_type' => $face->id]) }}" class="btn btn-gradient-light btn-rounded btn-sm" title="Edit">
                        <i class="mdi mdi-pencil"></i>
                      </a>
                      
                      <button type="button" class="btn btn-gradient-danger btn-rounded btn-sm btn-delete" data-type="{{ $face->face }}" data-action="{{ route('face.destroy', ['face' => $face->id]) }}">
                        <i class="mdi mdi-delete"></i>
                      </button>

                    </td> --}}
                  </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="mt-4">
        {{ $applications->links() }}
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
        var type = $(this).attr('data-type');
        var url = $(this).attr('data-action');
        swal({
          title: 'Are you sure?',
          text: `${type} will be delete. Would you like to continue?`,
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