<div class="panel panel-default">
    <div class="panel-heading">Карта затрат</div>
    <div id="expensemap"></div>
</div>


<script type="text/javascript">

    var map;
    function initMap() {
        var map = new google.maps.Map(document.getElementById('expensemap'), {
            center: {lat: 60.20807303, lng: 30.01146776},
            zoom: 8
        });
        @foreach($last_week_expense as $expense)
            new google.maps.Marker({
            position: {lat: {{$expense->lat}}, lng: {{$expense->lng}}},
            map: map,
            title: '{{$expense->reason_name}}'
        });
        @endforeach
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfl7fE1Xmr_N7omHlZ2FNsmRWk_KajtSo&callback=initMap">
</script>

