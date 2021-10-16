@extends('layouts.app')

@section('content') 
<h1>Имоти</h1>

    TOP:
    @foreach ($top as $imot)
      <p>This is imot ID:{{ $imot['id'] }} {{ $imot['title'] }} {{ $imot['status'] }} {{ $imot['agent_id'] }} </p>
    @endforeach
    

    All: {{$imoti->total()}}
    @foreach ($imoti as $imot)
    <p>This is imot ID:{{ $imot['id'] }} {{ $imot['status'] }} {{ $imot['price'] }} {{ $imot['size'] }}  {{ $imot['type'] }} {{ $imot['agent_id'] }}/{{ $imot->agent->name ?? 'Без агент' }} {{ $imot['area_id'] }}/{{ $imot->area->name ?? 'Без район' }}  </p>
    @endforeach

    {!! $imoti->links() !!}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
