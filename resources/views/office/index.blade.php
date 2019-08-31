@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Office </h3>

    <a href="{{ route('office.create') }}" class="btn btn-gradient-primary"><i class="mdi mdi-plus"></i> Add new office</a>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Office list</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="scope"> ID </th>
                  <th> State </th>
                  <th> City </th>
                  <th> Address </th>
                  <th> name </th>
                  <th> Logo </th>
                  <th> Agent </th>
                  <th> Verified </th>
                  <th> Govt </th>
                  <th> Last updated </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>

                @foreach ($offices as $office)
                  <tr>
                    <td>{{ $office->id }}</td>
                    <td> <strong>{{ $office->state->name }}</strong> </td>
                    <td>@if ($office->hasCity()) {{$office->city->name}} @endif</td>
                    <td>{{$office->address}}</td>
                    <td>{{$office->name}}</td>
                    <td class="text-center">
                      @if ($office->logo)
                          <img src="{{asset($office->logo)}}" alt="" class="rounded-0">
                      @else
                          --
                      @endif
                    </td>
                    <td>
                      @if($office->agent)
                        <strong>
                          {{$office->agent->name}} <br>
                          {{$office->agent->mobile}}
                        </strong>
                      @endif
                    </td>
                    <td>
                      @if($office->verified == 1)
                        <label class="badge badge-gradient-success">Yes</label>
                      @else
                        <label class="badge badge-gradient-light">No</label>
                      @endif
                    </td>
                    <td>
                      @if ($office->govt == 1)
                        <label class="badge badge-gradient-success">Yes</label>
                      @else
                        <label class="badge badge-gradient-light">No</label>                          
                      @endif
                    </td>
                    
                    <td> {{ $office->updated_at->diffForHumans() }} </td>
                    <td>
                      <a href="{{ route('office.edit', ['office' => $office->id]) }}" class="btn btn-gradient-light btn-rounded btn-sm" title="Edit">
                        <i class="mdi mdi-pencil"></i>
                      </a>

                      <button type="button" class="btn btn-gradient-danger btn-rounded btn-sm btn-delete" data-state="{{ $office->address }}"
                         data-action="{{ route('office.destroy', ['office' => $office->id]) }}">
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
        {{ $offices->links() }}
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
          text: `The office will be delete. Would you like to continue?`,
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