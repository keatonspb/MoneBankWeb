/**
 * Created by default on 27.03.2017.
 */

Chart.defaults.global.fontFamily = "'Open Sans', sans-serif";
Chart.defaults.global.fontColor = "#333333"

if($(".chart").length) {
    $(".chart").each(function () {

        if($(this).data("href")) {
            var that = this;
            var ctx = $("canvas",that);
            $(that).addClass("filled");
            $.getJSON($(this).data("href"), function (json) {
                new Chart(ctx, {
                    type: 'line',
                    data: json.data,
                    // options: {
                    //     scales: {
                    //         xAxes: [{
                    //             type: 'time',
                    //             time: {
                    //                 displayFormats: {
                    //                     quarter: 'll'
                    //                 }
                    //             }
                    //         }]
                    //     }
                    // }
                });
            });
        }
    });

}