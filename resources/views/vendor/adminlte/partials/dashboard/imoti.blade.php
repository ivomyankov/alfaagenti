@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dash Имоти</h1> 
@stop

@section('content')
    <!-- Main content --> 

    <div class="row">
      <div class="col-md-12">
        <!-- Application buttons -->
        @if($stats['agent']->role == 'admin')
        <a class="btn btn-app" href="{{ route('dashImoti') }}" target="_self">
          <span class="badge bg-purple">{{$stats['all']}}</span>
          <i class="fas fa-users"></i> Всички 
        </a>
        @endif
        <a class="btn btn-app" href="{!! route('dashImoti', ['agent_id' => $stats['agent']['id']]) !!}" target="_self">
          <span class="badge bg-primary">{{$stats['mine']}}</span>
          <i class="fas fa-user"></i> Мои
        </a>
         <a class="btn btn-app" href="{!! route('dashImoti', ['agent_id' => $stats['agent']['id'], 'status' => 'active' ]) !!}" >
         <span class="badge bg-success">{{$stats['active']}}</span>
           <i class="fas fa-globe"></i> Активни
         </a>                 
         <a class="btn btn-app" href="{!! route('dashImoti', ['agent_id' => $stats['agent']['id'], 'status' => 'active' ]) !!}" >
         <span class="badge bg-warning">{{$stats['inactive']}}</span>
           <i class="fas fa-moon"></i> Не активни
         </a>
         <a class="btn btn-app" href="{!! route('dashImoti', ['agent_id' => $stats['agent']['id'], 'private' => 1 ]) !!}" >
         <span class="badge bg-secondary">{{$stats['private']}}</span>
           <i class="fas fa-user-lock"></i> Лични
         </a>
         @if($stats['agent']->role == 'admin')
         <a class="btn btn-app" href="{!! route('dashImoti', ['agent_id' => $stats['agent']['id'], 'deleted' => 1 ]) !!}" >
           <span class="badge bg-danger">{{$stats['deleted']}}</span>
           <i class="fas fa-trash-alt"></i> Кошче
        </a>
        @endif
      </div>  
      <div class="col-md-12 mb-2">
        <div class="btn-group ml-2">
          <select class="form-control" id="sel1">
            <option>Масови Действия</option>
            <option>Редактиране</option>
            <option>Изтриване</option>
          </select>
        </div>
        @if($stats['agent']->role == 'admin')
        <div class="btn-group ml-2"> {{Session::get('agent_id') ?? 'N/A'}}
          <form id="switchAgent" method="POST" action="">
          @csrf
            <select class="form-control" id="dynamic_select" onchange="this.form.submit()>
              <option selected="selected" value="0" >Всички агенти</option>
              @foreach($agents_list as $agent)
              <option value="{{$agent->id}}">{{$agent->name}}</option>
              @endforeach
            </select>          
          </form>
        </div>
        @endif
        <div class="btn-group ml-2">
            <select class="form-control" id="sel3">
              <option selected="selected" value="0">Всички дати</option>
              <option value="202101">януари 2021</option>
              <option value="202012">декември 2020</option>
              <option value="202011">ноември 2020</option>
              <option value="202010">октомври 2020</option>
              <option value="202009">септември 2020</option>
              <option value="202008">август 2020</option>
              <option value="202007">юли 2020</option>
              <option value="202006">юни 2020</option>
              <option value="202005">май 2020</option>
              <option value="202004">април 2020</option>
              <option value="202003">март 2020</option>
              <option value="202002">февруари 2020</option>
              <option value="202001">януари 2020</option>
              <option value="201912">декември 2019</option>
              <option value="201911">ноември 2019</option>
              <option value="201910">октомври 2019</option>
              <option value="201909">септември 2019</option>
              <option value="201908">август 2019</option>
              <option value="201907">юли 2019</option>
              <option value="201906">юни 2019</option>
              <option value="201905">май 2019</option>
              <option value="201904">април 2019</option>
              <option value="201903">март 2019</option>
              <option value="201902">февруари 2019</option>
              <option value="201901">януари 2019</option>
              <option value="201812">декември 2018</option>
              <option value="201811">ноември 2018</option>
              <option value="201810">октомври 2018</option>
              <option value="201809">септември 2018</option>
              <option value="201808">август 2018</option>
              <option value="201807">юли 2018</option>
              <option value="201806">юни 2018</option>		
            </select>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
              
              <div class="row">
                <div class="col-sm-12">
                  <table id="example1" class=" table table-bordered table-striped table-hover" style="width:100%">
                    <thead>
                      <tr>
                        <th class="all">Реф. #</th>
                        <th class="all">Имот</th>
                        @if($stats['agent']->role == 'admin')
                        <th class="min-desktop sorting">Агент</th>
                        @endif
                        <th>Статус</th>
                        <th class="min-desktop sorting text-center">Снимка</th>
                        <th class="min-tablet sorting">Топ</th>
                        <th class="min-tablet sorting">Лична</th>
                        @if($stats['agent']->role == 'admin')
                        <th class="min-desktop sorting">Изтрита</th>
                        @endif
                        <th class="all">Цена</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($imoti as $imot)       
                        <tr>
                          <td>{{ $imot['id'] ?: '' }}</td>
                          <td><a href="{{route('dashImot', $imot['id'])}}" target="_self">{{$imot['type']}} / {{ isset($imot->area->name) ? $imot->area->name : '~' }} / {{ $imot['city'] }}</a></td>
                          @if($stats['agent']->role == 'admin')
                          <td>{{ isset($imot->agent->name) ? $imot->agent->name : '~' }}</td>
                          @endif
                          <td>
                            @if ($imot['status'] == 'Продажба' || $imot['status'] == 'Наем') 
                              <span style="color: #28a745;">{{ $imot['status'] }}</span>
                            @elseif ($imot['status'] == 'Продаден' || $imot['status'] == 'Отдаден') 
                              <span style="color: #dc3545;">{{ $imot['status'] }}</span>
                            @else
                              {{ $imot['status'] }}
                            @endif
                          
                          </td>
                          <td class="text-center">
                            @if (isset($imot->images[0]->filename))
                              <img style="width: 47px; margin: -0.5rem;" src="{{ asset('') }}{{ $imot->images[0]->path }}{{ $imot->id }}_{{ $imot->images[0]->filename }}-120x120.jpg">
                            @endif
                          </td>
                          <td>
                            @if ($imot['top'] == 1)
                              <i class="fas fa-check" style="color: green;"></i>
                            @endif
                          </td>
                          <td>
                            @if ($imot['private'] == 1)
                              <i class="fas fa-check"></i>
                            @endif
                          </td>  
                          @if($stats['agent']->role == 'admin')                        
                          <td>                          
                            @if ($imot['deleted'] == 1)
                              <i class="fas fa-check"></i>
                            @endif
                          </td>
                          @endif
                          <td>{{ $imot['price'] ?: '' }}</td>
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
