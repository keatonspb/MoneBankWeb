@extends('layouts.app_inner')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Фильтр
        </div>
        <div class="panel-body">
            <form>
            <div class="row">
                <div class="col-lg-4">
                    <label for="filter_from">Дата</label>
                    <div class="input-daterange input-group">
                        <input type="text" class="form-control" name="start" value="{{$filter['start']}}" />
                        <span class="input-group-addon"> &mdash; </span>
                        <input type="text" class="form-control" name="end" value="{{$filter['end']}}" />
                    </div>
                </div>
                <div class="col-lg-3">
                    <label>Тип</label>
                    <select name="type" class="form-control">
                        <option value="0">Все</option>
                        <option value="expense" @if(isset($filter['type']) && $filter['type'] == 'expense') selected @endif>Затраты</option>
                        <option value="income" @if(isset($filter['type']) && $filter['type'] == 'income') selected @endif>Пополнения</option>
                    </select>
                </div>
                <div class="col-lg-3">

                </div>
                <div class="col-lg-2">
                    <button class="btn btn-primary">Применить</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Дата</th>
                    <th>Сумма</th>
                    <th>Причина</th>
                    <th></th>
                </tr>
                <tr>
                    <th></th>
                    <th>{{ number_format($allSum, 2, ".", " ") }}</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                @foreach($rows as $row)
                    <tr>
                        <td>{{$row->created_at}}</td>
                        <td>@if($row->type == 'expense') - @endif
                            {{ number_format($row->value, 2, ".", " ") }}</td>
                        <td>{{$row->reason_name}}</td>
                        <td class="text-right">
                            <a class="btn btn-default btn-sm bill_item" href="/api/bill_info?id={{$row->id}}">Просмотр</a>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $rows->links() }}
        </div>
    </div>
    @include('frg/modal_bill_view')
@endsection