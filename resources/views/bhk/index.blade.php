@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> BHK types </h3>

    <a href="{{ route('bhk.create') }}" class="btn btn-gradient-primary"><i class="mdi mdi-plus"></i> Add BHK type</a>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">List of all BHK types</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="scope"> ID </th>
                  <th> Type </th>
                  <th> Created </th>
                  <th> Last updated </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>

                @foreach ($bhks as $bhk)
                  <tr>
                    <td>{{ $bhk->id }}</td>
                    <td> <strong>{{ $bhk->type }}</strong> </td>
                    <td> {{ $bhk->created_at->diffForHumans() }} </td>
                    <td> {{ $bhk->updated_at->diffForHumans() }} </td>
                    <td>
                      <a href="{{ route('bhk.edit', ['property_type' => $bhk->id]) }}" class="btn btn-gradient-light btn-rounded btn-sm" title="Edit">
                        <i class="mdi mdi-pencil"></i>
                      </a>
                      
                      <button type="button" class="btn btn-gradient-danger btn-rounded btn-sm btn-delete" data-type="{{ $bhk->type }}" data-action="{{ route('bhk.destroy', ['bHK' => $bhk->id]) }}">
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
        {{ $bhks->links() }}
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