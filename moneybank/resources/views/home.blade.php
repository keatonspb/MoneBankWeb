@extends('layouts.app')

@section('content')
<div class="container" id="app" xmlns:v-on="http://www.w3.org/1999/xhtml">

    <div class="row">
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">Аккаунт</div>
                <div class="panel-body">
                    <i class="fa fa-money" aria-hidden="true"></i> {{ $Account->credit }}
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">Пополнения и затраты</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5><i class="fa fa-minus-circle" aria-hidden="true"></i>
                                 Затраты</h5>
                            <ul class="list-group">
                                <li class="list-group-item">Cras justo odio</li>
                                <li class="list-group-item">Dapibus ac facilisis in</li>
                                <li class="list-group-item">Morbi leo risus</li>
                                <li class="list-group-item">Porta ac consectetur ac</li>
                                <li class="list-group-item">Vestibulum at eros</li>
                            </ul>
                            <a href="/bill/expenses" class="pull-right" style="margin: -10px 0 10px 0;">Все затраты</a>

                            <button class="btn btn-danger btn-block add_bill" data-role="expense" v-on:click="addBill('expense')"><i class="fa fa-minus-circle" aria-hidden="true"></i> Потратить</button>
                            @include('frg/modal_bill')

                        </div>
                        <div class="col-lg-6">
                            <h5><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                 Пополнения</h5>
                            <button class="btn btn-success btn-block add_bill" data-role="income" v-on:click="addBill('income')"><i class="fa fa-plus-circle" aria-hidden="true"></i> Пополнить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
