@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Advertisement </h3>

    <a href="{{ route('advertisement.create') }}" class="btn btn-gradient-primary"><i class="mdi mdi-plus"></i> Add new Advertisement</a>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">All advertisements</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="scope"> ID </th>
                  <th> Title </th>
                  <th> State </th>
                  <th> City </th>
                  <th> Last updated </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>

                @foreach ($ads as $ad)
                  <tr>
                    <td>{{ $ad->id }}</td>
                    <td> <strong>{{ $ad->title }}</strong> </td>
                    <td>{{ $ad->state_id ? $ad->state->name : '--' }}</td>
                    <td>{{ $ad->city_id ? $ad->city->name : '--' }}</td>
                    <td> {{ $ad->updated_at->diffForHumans() }} </td>
                    <td>
                      <a href="{{ route('advertisement.edit', ['advertisement' => $ad->id]) }}" class="btn btn-gradient-light btn-rounded btn-sm" title="Edit">
                        <i class="mdi mdi-pencil"></i>
                      </a>

                      <button type="button" class="btn btn-gradient-danger btn-rounded btn-sm btn-delete" data-action="{{ route('advertisement.destroy', ['advertisement' => $ad->id]) }}">
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
        {{ $ads->links() }}
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
        var state = $(this).attr('data-state');
        var url = $(this).attr('data-action');
        swal({
          title: 'Are you sure?',
          text: `Advertisement will be delete. Would you like to continue?`,
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