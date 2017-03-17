@extends('layouts.app_inner')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Пополнения и затраты</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">
                    <h5><i class="fa fa-minus-circle" aria-hidden="true"></i>
                        Затраты</h5>

                    <button class="btn btn-danger btn-block add_bill" data-role="expense"><i
                                class="fa fa-minus-circle" aria-hidden="true"></i> Потратить
                    </button>
                    <div class="list-group" style="margin-top: 10px;">
                        @foreach($last_expense as $row)
                            <a class="list-group-item bill_item" href="/api/bill_info?id={{$row->id}}">
                                <div>
                                    <span class="bill_value">{{ number_format($row->value, 2, ".", " ") }}</span>
                                    <div class="pull-right bill_date">{{$row->created_at}}</div>
                                </div>
                                <div class="help-block">{{$row->reason_name}}</div>
                            </a>
                        @endforeach

                    </div>

                    <a href="/bills?type=expense" class="pull-right" style="margin: -10px 0 10px 0;">Все
                        затраты</a>


                </div>
                <div class="col-lg-6">
                    <h5><i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Пополнения</h5>
                    <button class="btn btn-success btn-block add_bill" data-role="income"
                    ><i class="fa fa-plus-circle"
                        aria-hidden="true"></i> Пополнить
                    </button>
                    <div class="list-group" style="margin-top: 10px;">
                        @foreach($last_income as $row)
                            <a class="list-group-item bill_item" href="/api/bill_info?id={{$row->id}}">
                                <div>
                                    <span class="bill_value">{{ number_format($row->value, 2, ".", " ") }}</span>
                                    <div class="pull-right bill_date">{{$row->created_at}}</div>
                                </div>
                                <div class="help-block">{{$row->reason_name}}</div>
                            </a>
                        @endforeach

                    </div>

                    <a href="/bills?type=income" class="pull-right" style="margin: -10px 0 10px 0;">Все
                        пополнения</a>
                </div>
            </div>
        </div>
    </div>

    @include('frg/modal_bill')
    @include('frg/modal_credit_pay')
    @include('frg/modal_bill_view')
@endsection
