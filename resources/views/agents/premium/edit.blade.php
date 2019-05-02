@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Premium Agents: {{ $agent->user->name }} </h3>

  </div>

  <form autocomplete="off" action="{{ route('agents.premium.make', ['id' => $agent->id]) }}" method="POST">
    @csrf
    <div class="row">

      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">More information</div>

            <div class="form-group">
              <label for="area">Choose area</label>
              <select name="area" id="area" class="form-control{{ $errors->has('area') ? ' is-invalid' : '' }}">
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" {{ $agent->area_id == $area->id ? 'selected' : '' }}>{{ $area->area }}</option>
                @endforeach
              </select>

              @if ($errors->has('area'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('area') }}</strong>
                </span>
              @endif

            </div>

            <div class="form-group">
              <label for="landmark">Choose landmark</label>
              <select name="landmark" id="landmark" class="form-control{{ $errors->has('landmark') ? ' is-invalid' : '' }}">
                @foreach ($landmarks as $landmark)
                    <option value="{{ $landmark->id }}" {{ $agent->landmark_id == $landmark->id ? 'selected' : '' }}>{{ $landmark->name }}</option>
                @endforeach
              </select>

              @if ($errors->has('landmark'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('landmark') }}</strong>
                </span>
              @endif

            </div>

          </div>
        </div>
      </div>

      <div class="col-md-12 mt-4">
        <button class="btn btn-gradient-primary mt-3" type="submit">Update Agent profile</button>
      </div>

    </div>
  </form>

  @endsection