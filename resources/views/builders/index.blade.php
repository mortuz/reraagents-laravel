@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Builders </h3>

    <a href="{{ route('builders.create') }}" class="btn btn-gradient-primary"><i class="mdi mdi-plus"></i> Add buildera</a>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Builders list</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="scope"> ID </th>
                  <th> Name </th>
                  <th> State </th>
                  <th> City </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>

                @foreach ($builders as $builder)
                  <tr>
                    <td>{{ $builder->user->id }}</td>
                    <td> <strong>{{ $builder->user->name }}</strong> </td>
                    <td> {{ $builder->state->name }} </td>
                    <td>@if($builder->city){{$builder->city->name}}@else -- @endif</td>
                    <td>
                      <a href="{{ route('builders.edit', ['builders' => $builder->id]) }}" class="btn btn-gradient-light btn-rounded btn-sm" title="Edit">
                        <i class="mdi mdi-pencil"></i>
                      </a>

                      <button type="button" class="btn btn-gradient-danger btn-rounded btn-sm btn-delete" data-name="{{ $builder->user->name }}"
                         data-action="{{ route('builders.destroy', ['builders' => $builder->id]) }}">
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
        {{ $builders->links() }}
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