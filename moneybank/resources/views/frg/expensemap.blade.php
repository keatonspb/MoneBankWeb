@if($map_center)
<div class="panel panel-default">
    <div class="panel-heading">Карта затрат</div>
    <div id="expensemap"></div>
</div>


<script type="text/javascript">

    var map;
    function initMap() {
        var map = new google.maps.Map(document.getElementById('expensemap'), {

            center: {lat: {{$map_center->lat}}, lng: {{$map_center->lng}}},
            zoom: 10
        });
        @foreach($last_week_expense as $expense)
            new google.maps.Marker({
            position: {lat: {{$expense->lat}}, lng: {{$expense->lng}}},
            map: map,
            title: '{{$expense->reason_name}} - {{$expense->value}}'
        });
        @endforeach
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfl7fE1Xmr_N7omHlZ2FNsmRWk_KajtSo&callback=initMap">
</script>
@endif

