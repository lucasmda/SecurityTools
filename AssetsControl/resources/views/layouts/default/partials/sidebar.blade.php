<nav>
  <div id="accordion" role="tablist" aria-multiselectable="true">
    <ul class="nav flex-column">
      <li class="nav-item">
        <div class="card" role="tab">
          <a class="nav-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" aria-labelledby="headingOne">
            Tickets & Changes
          </a>
          <div id="collapseOne" class="collapse" role="tabpanel">
            <a href="{{ url('Change') }}">Changes</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <div class="card" role="tab">
          <a class="nav-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" aria-labelledby="headingTwo">
            Security Incidents
          </a>
          <div id="collapseTwo" class="collapse" role="tabpanel">
            <a href="{{ url('PreventiveMeasures') }}">Preventive Measures</a>
            <a href="{{ url('SecurityIncident') }}">Security Incidents</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <div class="card" role="tab">
          <a class="nav-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" aria-labelledby="headingThree">
            Extra DATs
          </a>
          <div id="collapseThree" class="collapse" role="tabpanel">
            <a href="{{ url('ExtraDAT') }}">Extra DATs</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <div class="card" role="tab">
          <a class="nav-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFor" aria-expanded="false" aria-controls="collapseFor" aria-labelledby="headingFor">
            CERT
          </a>
          <div id="collapseFor" class="collapse" role="tabpanel">
            <a href="#">Bulletins</a>
          </div>
        </div>
      </li>
    </ul>
  </div>
</nav>
