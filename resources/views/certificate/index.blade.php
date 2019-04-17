@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Certificates </h3>

    {{-- <a href="{{ route('certificate.create') }}" class="btn btn-gradient-primary"><i class="mdi mdi-plus"></i> Add New Certificate</a> --}}
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">List of all Certificates</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="scope"> ID </th>
                  <th> Agent name </th>
                  <th> State </th>
                  <th> Status </th>
                  <th> Last updated </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>

                @foreach ($certificates as $certificate)
                  <tr>
                    <td>{{ $certificate->id }}</td>
                    <td> <strong>{{ $certificate->user->name }}</strong> </td>
                    <td> {{ $certificate->state->name }} </td>
                    <td>
                      @switch($certificate->status)
                          @case(0)
                              <label class="badge badge-dark">Submitted</label>
                              @break
                          @case(1)
                              <label class="badge badge-success">Approved</label>
                              @break
                          @case(2)
                              <label class="badge badge-danger">Rejected</label>
                              @break
                          @default
                              
                      @endswitch
                    </td>
                    <td> {{ $certificate->updated_at->diffForHumans() }} </td>
                    <td>
                      <a href="{{ route('certificate.edit', ['certificate' => $certificate->id]) }}" class="btn btn-gradient-light btn-rounded btn-sm" title="Edit">
                        <i class="mdi mdi-pencil"></i>
                      </a>
                      
                      {{-- <button type="button" class="btn btn-gradient-danger btn-rounded btn-sm btn-delete" data-type="{{ $face->face }}" data-action="{{ route('certificate.destroy', ['certificate' => $face->id]) }}">
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
        {{ $certificates->links() }}
      </div>

    </div>
  </div>
  <form class="d-none" action="#" method="post" id="delete-form">
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