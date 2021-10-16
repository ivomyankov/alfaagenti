@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dash Agenti</h1> 
@stop

@section('content')
    <!-- Main content --> 

    <div class="row">
      <div class="col-md-12">
        <!-- Application buttons -->
        
      </div> 
      <div class="col-md-12">
        <div id="agenti" class="card" >
          <!-- /.card-header -->
          <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
              
              <div class="row">
                <div class="col-sm-12">
                  <table id="example1" class=" table table-bordered table-striped table-hover" style="width:100%">
                    <thead>
                      <tr>
                        <th class="all text-center">Реф. #</th>
                        <th class="all text-center">Агент</th>
                        <th class="text-center">Снимка</th>
                        <th class="text-center">Роля</th>
                        <th class="min-desktop sorting text-center">Блокиран</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($agenti as $agent)       
                        <tr>
                          <td class="text-center align-middle">{{ $agent['id'] }}</td>
                          <td class="text-center align-middle"><a href="{{route('dashImot', $agent['id'])}}" target="_self">{{ $agent->name}}</a></td>
                          <td class="text-center align-middle"><img width="40px" src="{{ asset('images/agenti/') }}/{{ $agent['profile_img'] }}"></td>
                          <td class="text-center align-middle">
                            @if($agent['role']=='admin')
                              <i class="fas fa-user-secret fa-2x" title="{{ $agent['role'] }}"></i>
                            @else
                              <i class="fas fa-user fa-2x" title="{{ $agent['role'] }}"></i>
                            @endif
                            {{-- $agent['role'] --}}
                          </td>
                          <td class="text-center align-middle">
                            @if ($agent['banned'] == 1)
                              <a class="dropdown-item" href="" onclick="event.preventDefault(); document.getElementById('unban{{ $agent['id'] }}').submit();">
                                <i class="fas fa-toggle-on fa-1x"></i>
                              </a>
                              <form id="unban{{ $agent['id'] }}" action="{{ route('unban', ['id' => $agent['id']]) }}" method="POST" class="d-none">
                                @csrf
                              </form>
                            @else
                              <a class="dropdown-item" href="" onclick="event.preventDefault(); document.getElementById('ban{{ $agent['id'] }}').submit();">
                                <i class="fas fa-toggle-off fa-1x"></i>
                              </a>
                              <form id="ban{{ $agent['id'] }}" action="{{ route('ban', ['id' => $agent['id']]) }}" method="POST" class="d-none">
                                @csrf
                              </form>
                            @endif
                          </td> 
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
                
            </div>    
          </div>
          <!-- /.card-body -->
        </div>      
      </div> 
      <!-- /.col --> 
    </div>
    
    <!-- /.content -->
@stop

@section('css')
   <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
  <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
  <script src="{{ asset('vendor/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

  <!--  <script> console.log('Hi1!'); </script> -->
  <!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false,
      "buttons": ["colvis",'pageLength'],      
      //"pageLength": 20,
      //"order": [[ 3, "desc" ]]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');    
  });

  
</script>
@stop
