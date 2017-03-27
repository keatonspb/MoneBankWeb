<div class="panel panel-default">
    <div class="panel-heading">Статистика аккаунта</div>
    <div class="panel-body">
        <div class="chart">
            <canvas width="200" height="100"></canvas>
            <ul>
                @foreach($account_stat as $stat)
                    <li data-label="{{$stat->date}}">{{$stat->debit}}</li>
                @endforeach

            </ul>
        </div>

    </div>

</div>

