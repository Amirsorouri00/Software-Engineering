@extends('layouts.app')
@section('content')

    <div class="container">
        <h2>Active Baskets</h2>
        <p>Contextual classes can be used to color table rows or table cells. The classes that can be used are: .active,
            .success, .info, .warning, and .danger.</p>
        <table class="table">
            <thead>
            <tr>
                <th>BasketID</th>
                <th>QuestionID</th>
                <th>BasketScore</th>
                <th>ShowBasket</th>
            </tr>
            </thead>
            <tbody>
            <?php $cnt = 0; ?>
            @foreach($baskets as $b)
                @if($cnt%5 == 0)
                    <tr class="active">
                        <td>{{$b->basketID}}</td>
                        <td>{{$b->questionID}}</td>
                        <td>{{$b->basketScore}}</td>
                        <td style="direction: rtl;">
                            <form action="http://software:81/basket/{{$b->id}}" method="post">
                                <button class="btn btn-info col-md-4">Go</button>
                            </form>
                        </td>
                    </tr>
                    <?php $cnt++; ?>
                @elseif($cnt%5 == 1)
                    <tr class="success">
                        <td>{{$b->basketID}}</td>
                        <td>{{$b->questionID}}</td>
                        <td>{{$b->basketScore}}</td>
                        <td style="direction: rtl;">
                            <form action="http://software:81/basket/{{$b->id}}" method="post">
                                <button class="btn btn-info col-md-4">Go</button>
                            </form>
                        </td>
                    </tr>
                    <?php $cnt++; ?>
                @elseif($cnt%5 == 2)
                    <tr class="info">
                        <td>{{$b->basketID}}</td>
                        <td>{{$b->questionID}}</td>
                        <td>{{$b->basketScore}}</td>
                        <td style="direction: rtl;">
                            <form action="http://software:81/basket/{{$b->id}}" method="post">
                                <button class="btn btn-info col-md-4">Go</button>
                            </form>
                        </td>
                    </tr>
                    <?php $cnt++; ?>
                @elseif($cnt%5 == 3)
                    <tr class="warning">
                        <td>{{$b->basketID}}</td>
                        <td>{{$b->questionID}}</td>
                        <td>{{$b->basketScore}}</td>
                        <td style="direction: rtl;">
                            <form action="http://software:81/basket/{{$b->id}}" method="post">
                                <button class="btn btn-info col-md-4">Go</button>
                            </form>
                        </td>
                    </tr>
                    <?php $cnt++; ?>
                @elseif($cnt%5 == 4)
                    <tr class="active">
                        <td>{{$b->basketID}}</td>
                        <td>{{$b->questionID}}</td>
                        <td>{{$b->basketScore}}</td>
                        <td style="direction: rtl;">
                            <form action="http://software:81/basket/{{$b->id}}" method="post">
                                <button class="btn btn-info col-md-4">Go</button>
                            </form>
                        </td>
                    </tr>
                    <?php $cnt++; ?>
                @endif
            @endforeach
            </tbody>
        </table>
        {{ $baskets->links() }}
    </div>




    <!--
    <div class="container">
        @foreach($baskets as $b)
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <label>basketID:</label>
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
            -->
@endsection