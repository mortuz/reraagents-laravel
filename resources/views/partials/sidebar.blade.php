<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="{{ asset('images/faces/face1.jpg') }}" alt="profile">
          <span class="login-status online"></span> <!--change to offline or busy as needed-->              
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
          <span class="text-secondary text-small">{{ Auth::user()->role == 10 ? 'Super Admin' : 'Agent'}}</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('home') }}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('advertisement.index') }}">
        <span class="menu-title">Advertisement</span>
        <i class="mdi mdi-account-multiple menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#locations" aria-expanded="false" aria-controls="locations">
        <span class="menu-title">Locations</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-crosshairs-gps menu-icon"></i>
      </a>
      <div class="collapse" id="locations">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{ route('states.index') }}">States</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('cities.index') }}">Cities</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('landmark.index') }}">Landmark</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('area.index') }}">Area</a></li>
        </ul>
      </div>
    </li>
    
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#additional" aria-expanded="false" aria-controls="additional">
        <span class="menu-title">Additional</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-map-marker-plus menu-icon"></i>
      </a>
      <div class="collapse" id="additional">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{ route('bhk.index') }}">Room</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('face.index') }}">Face</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('property-types.index') }}">Property type</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('price.index') }}">Pricing</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('venture.index') }}">
        <span class="menu-title">Ventures</span>
        <i class="mdi mdi-account-multiple menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('office.index') }}">
        <span class="menu-title">Office</span>
        <i class="mdi mdi-office menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('callers.index') }}">
        <span class="menu-title">Callers</span>
        <i class="mdi mdi-office menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('call.records.index') }}">
        <span class="menu-title">Call records</span>
        <i class="mdi mdi-office menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('agents.index') }}">
        <span class="menu-title">Agents</span>
        <i class="mdi mdi-clipboard-account menu-icon"></i>
      </a>
    </li>
    
    <li class="nav-item">
      <a class="nav-link" href="{{ route('certificate.index') }}">
        <span class="menu-title">Certificates</span>
        <i class="mdi mdi-clipboard-account menu-icon"></i>
      </a>
    </li>


    <li class="nav-item">
      <a class="nav-link" href="{{ route('builders.index') }}">
        <span class="menu-title">Builders</span>
        <i class="mdi mdi-account menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('premium.request.index') }}">
        <span class="menu-title">Premium requests</span>
        <i class="mdi mdi-account menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#properties" aria-expanded="false" aria-controls="properties">
        <span class="menu-title">Properties</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-crosshairs-gps menu-icon"></i>
      </a>
      <div class="collapse" id="properties">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{ route('properties.index') }}">Properties</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('property.delete.request') }}">Delete requests</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#requirements" aria-expanded="false" aria-controls="requirements">
        <span class="menu-title">Requirements</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-crosshairs-gps menu-icon"></i>
      </a>
      <div class="collapse" id="requirements">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{ route('requirement.index') }}">Requirements</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('requirement.delete.request') }}">Delete requests</a></li>
        </ul>
      </div>
    </li>

    {{-- <li class="nav-item">
      <a class="nav-link" href="{{ route('requirement.index') }}">
        <span class="menu-title">Requiments</span>
        <i class="mdi mdi-clipboard-account menu-icon"></i>
      </a>
    </li> --}}

    <li class="nav-item">
      <a class="nav-link" href="{{ route('finance.index') }}">
        <span class="menu-title">Finance applications</span>
        <i class="mdi mdi-clipboard-account menu-icon"></i>
      </a>
    </li>


    {{-- <li class="nav-item">
      <a class="nav-link" href="../../pages/icons/mdi.html">
        <span class="menu-title">Icons</span>
        <i class="mdi mdi-contacts menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="../../pages/forms/basic_elements.html">
        <span class="menu-title">Forms</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="../../pages/charts/chartjs.html">
        <span class="menu-title">Charts</span>
        <i class="mdi mdi-chart-bar menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="../../pages/tables/basic-table.html">
        <span class="menu-title">Tables</span>
        <i class="mdi mdi-table-large menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
        <span class="menu-title">Sample Pages</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-medical-bag menu-icon"></i>
      </a>
      <div class="collapse" id="general-pages">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="../../pages/samples/blank-page.html"> Blank Page </a></li>
          <li class="nav-item"> <a class="nav-link" href="../../pages/samples/login.html"> Login </a></li>
          <li class="nav-item"> <a class="nav-link" href="../../pages/samples/register.html"> Register </a></li>
          <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-404.html"> 404 </a></li>
          <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-500.html"> 500 </a></li>
        </ul>
        </div>
    </li>
    <li class="nav-item sidebar-actions">
      <span class="nav-link">
        <div class="border-bottom">
          <h6 class="font-weight-normal mb-3">Projects</h6>                
        </div>
        <button class="btn btn-block btn-lg btn-gradient-primary mt-4">+ Add a project</button>
        <div class="mt-4">
          <div class="border-bottom">
            <p class="text-secondary">Categories</p>                  
          </div>
          <ul class="gradient-bullet-list mt-4">
            <li>Free</li>
            <li>Pro</li>
          </ul>
        </div>
      </span>
    </li> --}}
  </ul>
</nav>