<div class="bg-light border-right" id="layout-sidebar-wrapper">
    <div class="sidebar-heading">Start Bootstrap </div>
    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Cras justo odio
          <span class="badge badge-primary badge-pill">14</span>
        </li>
        <li class="list-group-item">
            <div class="row d-flex justify-content-between w-100">
                <div class="col">
                    <a href="#UserManageMent" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Relief Assistance</a>
                </div>
                <div>
                    <a href="#UserManageMent" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-caret-down"></i></a>
                </div>
            </div>
            <ul class="collapse list-unstyled" id="UserManageMent">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('constituent.relief-asst.receive', [Auth::id()]) }}">Receive</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#">Relief On Process</a>
                </li> --}}
            </ul>
        </li>
      </ul>
</div>
