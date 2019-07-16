@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Properties </h3>

    <a href="{{ route('properties.create') }}" class="btn btn-gradient-primary"><i class="mdi mdi-plus"></i> Add new property</a>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <form action=""  autocomplete="off">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="state">State</label>
                  <select name="state" id="state" class="form-control js-state-field">
                    <option value="0">All states</option>
                    @foreach ($states as $state)
                      <option value="{{$state->id}}" {{$filters['state'] == $state->id ? 'selected' : ''}}>{{$state->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label for="city">City</label>
                  <select name="city" id="city" class="form-control js-city-field{{ $errors->has('city') ? ' is-invalid' : '' }}" data-preselect="{{ $filters['city'] }}">
                  </select>

                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="type">Property type</label>
                  <input id="type" name="type" data-preselect="{{ $filters['type'] }}" data-url={{ route('api.propertytype.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label for="area">Area</label>
                  <input id="area" name="area" data-preselect="{{ $filters['areas'] }}" data-url={{ route('api.area.index') }} data-dependency="city" type="text" class="form-control js-selectize"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="price">Price</label>
                  <input id="price" name="price" data-preselect="{{ $filters['prices'] }}" data-url={{ route('api.price.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control js-status" id="status" name="status">
                    <option value="" {{ $filters['status'] === '' ? 'selected' : '' }}>All</option>
                    <option value="0" {{ $filters['status'] === '0' ? 'selected' : '' }}>New</option>
                    <option value="1" {{ $filters['status'] == 1 ? 'selected' : '' }}>Approved</option>
                    <option value="2" {{ $filters['status'] == 2 ? 'selected' : '' }}>Rejected</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <button class="btn btn-gradient-primary mt-3" type="submit">Filter</button>
                <a href="{{route('properties.index')}}" class="btn btn-gradient-secondary mt-3">Clear</a>
              </div>

            </div>
            
          </form>
          
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Property list</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="scope"> ID </th>
                  <th> Type </th>
                  <th> City </th>
                  <th> Area </th>
                  <th> Landmark </th>
                  <th> Price </th>
                  <th> Measurement </th>
                  <th> Details </th>
                  <th> Expiry date </th>
                  <th> Status</th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>

                @foreach ($properties as $property)
                  <tr>
                    <td>{{ $property->id }} {!!$property->premium ? '<label class="badge badge-sm badge-danger">Premium</label>' : '' !!}</td>
                    <td>
                      @foreach ($property->propertytypes as $type)
                        <label>{{$type->type}}</label> <br>
                      @endforeach
                    </td>
                    <td>{{ $property->city ? $property->city->name : null }}</td>
                    <td>
                      @foreach ($property->areas as $area)
                          <label>{{ $area->area }}</label> <br>
                      @endforeach
                    </td>
                    <td>
                      @foreach ($property->landmarks as $landmark)
                          <label>{{ $landmark->name }}</label> <br>
                      @endforeach
                    </td>
                    <td>
                      @if ($property->prices->first())
                        @foreach ($property->prices as $price)
                          <label>{{ $price->price }}</label> <br>
                        @endforeach
                      @else
                        --
                      @endif
                    </td>
                    
                    <td style="max-width: 100px; white-space: normal;"> {{ json_decode($property->raw_data)->measurement }} </td>
                    <td style="max-width: 200px; white-space: normal;"> <span>{{ json_decode($property->raw_data)->details }}</span> </td>
                    <td> {{ \Carbon\Carbon::parse($property->expiry_date)->format('d-m-Y') }} </td>
                    <td>
                      @switch($property->status)
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
                    <td>
                      <a href="{{ route('properties.edit', ['property' => $property->id]) }}" class="btn btn-gradient-light btn-rounded btn-sm" title="Edit">
                        <i class="mdi mdi-pencil"></i>
                      </a>

                      <button type="button" class="btn btn-gradient-danger btn-rounded btn-sm btn-delete" data-id="{{ $property->id }}" data-action="{{ route('properties.destroy', ['property' => $property->id]) }}">
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
        {{ $properties->links() }}
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
          text: `Property ${id} will be permanently deleted. Would you like to continue?`,
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
      $(document).on('city_init', function() {
        initSelectize();
      });

      $(document).on('city_changed', function() {
      });
    </script>
@endsection