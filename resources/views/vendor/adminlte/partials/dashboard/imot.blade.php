@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Имот# </h1> 
@stop

@section('content')
    <!-- Main content --> 
  
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Rendering engine</th>
                      <th>Browser</th>
                      <th>Platform(s)</th>
                      <th>Engine version</th>
                      <th>CSS grade</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Trident</td>
                      <td>Internet
                        Explorer 4.0
                      </td>
                      <td>Win 95+</td>
                      <td> 4</td>
                      <td>X</td>
                    </tr>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                  </tr>
                  </tfoot>
                </table>
          </div>
          <!-- /.card-body -->
        </div>      
      </div> 
      <!-- /.col --> 
      <div class="col-md-12">
        dfg
      </div>
      <!-- /.col -->
    </div>
    
    {{ $imot[0]->agent->name }}
    <p>This is imot ID:{{ $imot[0]->id }} {{ $imot[0]->title }} {{ $imot[0]->status }} {{ $imot[0]->agent_id }} {{ $imot[0]->agent_id }} {{ $imot[0]->agent->name }}   </p>
    
    @if (isset($imot[0]->images[0]->filename))
      <ul class="inline sortbl">
      @foreach ($imot[0]->images as $key => $image)  
        <li class="reposition" id="{{$image->id}}"><img title="{{ $image->id }}" src="{{ asset('') }}{{ $image->path }}{{ $imot[0]->id }}_{{ $image->filename }}-120x120.jpg"></li>
        <i class="fas fa-trash img_del" onclick="document.getElementById('del_{{ $image->id }}').submit();"></i>
        <form id="del_{{ $image->id }}" method="POST" action="{{ route('imageDelete', $image->id) }}">
          @csrf
        </form>
      @endforeach
      </ul>
    @endif

    <form enctype="multipart/form-data" action="{{ route('imageUpload') }}" method="post">
      <label>Update profile image</label><br>
      <input type="file" name="photo">
      <input type="hidden" name="imot_id" value="{{ $imot[0]->id }}">
      <input type="hidden" name="position" value="{{ isset($key) ? $key+2 : 1 }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="submit" class="pull-right btn btn-sm btn-primary">
    </form>

    <form style="display:none;" id="reposition" action="{{ route('imageReposition') }}" method="post">
      <input id="data" type="input" name="data" value="">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>


   

    <!-- /.content -->
@stop

@section('css')
   <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
   <link href="{{ asset('vendor/dragable-sortable/draganddrop.css') }}" rel='stylesheet' type='text/css'>
   

@stop

@section('js')
  <script src="{{ asset('vendor/dragable-sortable/draganddrop.js') }}" type='text/javascript'></script>
   <!--  <script> console.log('Hi!'); </script> -->
  <script type='text/javascript'>
    $(function() {    
      var position;    
      $('ul.inline').sortable({
        update: function(evt) {
           //console.log(JSON.stringify($(this).sortable('serialize')));
           $('#data').val(JSON.stringify($(this).sortable('serialize')));
           $('form#reposition').submit();
        }
      });      
    });
  </script>
    

@stop
