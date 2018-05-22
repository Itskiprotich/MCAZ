$(function() {

    var cache10 = {},    lastXhr10;
    $( "#description-of-reaction" ).autocomplete({
        source: function( request, response ) {
            var term = request.term;
            if ( term in cache10 ) {
                response( cache10[ term ] );
                return;
            }

            lastXhr10 = $.getJSON( "/aefis/reports.json", request, function( data, status, xhr ) {
                cache10[ term ] = data;
                if ( xhr === lastXhr10 ) {
                    response( data );
                }
            });
        },
        select: function( event, ui ) {
            $( "#description-of-reaction" ).val( ui.item.label );
            return false;
        }
    });

    var cache1 = {},    lastXhr1;
    $( "#signs-symptoms" ).autocomplete({
        source: function( request, response ) {
            var term = request.term;
            if ( term in cache1 ) {
                response( cache1[ term ] );
                return;
            }

            lastXhr1 = $.getJSON( "/meddras/terminology.json", request, function( data, status, xhr ) {
                cache1[ term ] = data;
                if ( xhr === lastXhr1 ) {
                    response( data );
                }
            });
        },
        select: function( event, ui ) {
            $( "#signs-symptoms" ).val( ui.item.label );
            return false;
        }
    });

    $('#autopsy-done-date, #died-date, #symptom-date, #person-date').datetimepicker({
        //minDate:"-100Y", 
        maxDate:"0",
        format: 'd-m-Y H:i'
      });

    $('#report-date, #start-date, #complete-date, #hospitalization-date, #date-of-birth').datepicker({
        minDate:"-100Y", maxDate:"-0D", 
        dateFormat:'dd-mm-yy', 
        showButtonPanel:true, 
        changeMonth:true, 
        changeYear:true, 
            yearRange: "-100Y:+0",
        showAnim:'show'
      });

     $('#autopsy-planned-date').datepicker({
        minDate:"-100Y", maxDate:"+1Y", 
        dateFormat:'dd-mm-yy', 
        showButtonPanel:true, 
        changeMonth:true, 
        changeYear:true, 
            yearRange: "-100Y:+0",
        showAnim:'show'
      });

    //active for admins
    //https://stackoverflow.com/questions/18999501/bootstrap-3-keep-selected-tab-on-page-refresh
    $('a[data-toggle="tab"]').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href");
        localStorage.setItem('selectedTab', id)
    });

    var selectedTab = localStorage.getItem('selectedTab');
    if (selectedTab != null) {
        $('a[data-toggle="tab"][href="' + selectedTab + '"]').tab('show');
    }
});
