@extends('layouts.app')
@section('content')
<div class="container">

    @foreach($baskets as $b)
    <div class="panel panel-default ">
        <div class="panel-heading">
           <a href="basket/{{$b->id}}"> {{$b->basketID}}</a>

        </div>
        <div class="panel-body">
            {{$b->questionID}}
        </div>
        <div class="panel-footer">
        {{$b->basketScore}}

   </div>
    </div>
    @endforeach
        {{ $baskets->links() }}
</div>
@endsection