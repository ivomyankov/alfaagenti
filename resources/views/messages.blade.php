<div class="flash-message" style="position:absolute; right:0; margin:10px; z-index:9999;">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
    @if ($errors->any())
    
      @foreach ($errors->all() as $error)
           <p class="alert alert-danger">{{ $error }}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
       @endforeach
        
    @endif
 
  </div> <!-- end .flash-message -->
