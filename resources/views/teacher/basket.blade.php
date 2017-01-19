@extends('layouts.app')
@section('content')

    <div class="container">

        <div class="panel panel-default">
            <form  action="{{url('basketupdate/' . $basket->id)}}" method="POST">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-1">
                            <label for="email">امتیاز</label>
                            <input type="number" name="score" class="form-control" min="0" max="20" id="email"
                                   value="{{$basket->basketScore}}"
                                   oninvalid="setCustomValidity('لطفا نمره را بدرستی وارد کنید')">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>

            </form>

        </div>

    </div>


@endsection