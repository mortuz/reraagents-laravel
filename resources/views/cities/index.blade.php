@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Cities </h3>

    <a href="{{ route('cities.create') }}" class="btn btn-gradient-primary"><i class="mdi mdi-plus"></i> Add new city</a>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Cities list</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="scope"> ID </th>
                  <th> Name </th>
                  <th> State </th>
                  <th> Status </th>
                  <th> Last updated </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>

                @foreach ($cities as $city)
                  <tr>
                    <td>{{ $city->id }}</td>
                    <td> <strong>{{ $city->name }}</strong> </td>
                    <td> {{ $city->state->name}} </td>
                    <td>
                      @if ($city->status == 1)
                        <label class="badge badge-gradient-success">ACTIVE</label>
                      @else
                        <label class="badge badge-gradient-danger">INCTIVE</label>                          
                      @endif
                    </td>
                    <td> {{ $city->updated_at->diffForHumans() }} </td>
                    <td>
                      <a href="{{ route('cities.edit', ['city' => $city->id]) }}" class="btn btn-gradient-light btn-rounded btn-sm" title="Edit">
                        <i class="mdi mdi-pencil"></i>
                      </a>

                      @if ($city->status == 0)
                        <a href="{{ route('city.active', ['id' => $city->id]) }}" class="btn btn-gradient-light btn-rounded btn-sm" title="Active">
                          <i class="mdi mdi-eye"></i>
                        </a>
                      @else
                        <a href="{{ route('city.inactive', ['id' => $city->id]) }}" class="btn btn-gradient-dark btn-rounded btn-sm" title="Inactive">
                          <i class="mdi mdi-eye-off"></i>
                        </a>
                      @endif
                      
                      <button type="button" class="btn btn-gradient-danger btn-rounded btn-sm btn-delete" data-city="{{ $city->name }}" data-action="{{ route('cities.destroy', ['city' => $city->id]) }}">
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
        {{ $cities->links() }}
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
        var city = $(this).attr('data-city');
        var url = $(this).attr('data-action');
        swal({
          title: 'Are you sure?',
          text: `${city} will be delete. Would you like to continue?`,
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