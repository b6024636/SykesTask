$(document).ready(function(){
    $('#search-form').submit(function(e){
        e.preventDefault();
        let $data = JSON.parse(JSON.stringify($(this).serializeArray()));
        // console.log($data);
        $.ajax({
            url: '/searchsykes',
            data: $data,
            type: 'POST',
            beforeSend: function(){

                $('.ui.cards.link').html('<div class="ui segment"  style="width: 100%; height: 30vh;"><div class="ui active inverted dimmer"><div class="ui text loader">Loading</div></div></div>');
            },
            success: function (data, status) {
                displayProperties(JSON.parse(data));
            }
        });
    });
});

function displayProperties(data){
    let clashes = data.bookingClashes,
        noResults = data.noResults,
        properties = data.availableProperties;
    $('.ui.cards.link').html('');
    $('.row.results-feedback').html('');
    let html = '',
        feedback = '';
    if(noResults)
        feedback = '<i style="color: red;font-weight: bold">We are sorry, but there are currently no properties that meet these specifications.</i> <p style="font-weight: bold">Here are some other properties in this location:</p>';
    if(properties.length < 1){
        feedback = '<i style="color: red;font-weight: bold">We are sorry, but there are currently no properties that meet these specifications.</i>';
    }
    $('.row.results-feedback').html(feedback);
    for(var key in properties){
        let property = properties[key];
        html += "<div class=\"card\">\n" +
            "                        <div class=\"content\">\n" +
            "                            <div class=\"header\">\n" +
            "                                "+ property.property_name +"\n" +
            "                            </div>\n";

        for(var _key in clashes){
            if(property.__pk == clashes[_key].property)
                html += "<div class=\"meta\" style='color: red'>\n" +
                    "       Conflict in dates - This property is booked from "+ clashes[_key].bookedDates[0] +" to " + clashes[_key].bookedDates[1] + "\n" +
                    "    </div>\n";
        }

            html +="                 </div>\n" +
            "                        <div class=\"content\">\n" +
            "                            <div class=\"ui two column grid\">\n" +
            "                                <div class=\"row d-flex pl-3\">\n" +
            "                                    <div class=\"column\">\n" +
            "                                        <div class=\"ui basic "+ (property.near_beach == 1 ? "green" : "red") +" button\">" + (property.near_beach == 1 ? "Near Beach" : "Not near a beach") + "</div>\n" +
            "                                    </div>\n" +
            "                                    <div class=\"column\">\n" +
            "                                        <div class=\"ui basic "+ (property.accepts_pets == 1 ? "green" : "red") +" button\">"+ (property.accepts_pets == 1 ? "Pets Allowed" : "No pets allowed") +"</div>\n" +
            "                                    </div>\n" +
            "                                </div>\n" +
            "                                <div class=\"row d-flex pl-3\">\n" +
            "                                    <div class=\"column\">\n" +
            "                                        <div class=\"ui secondary basic button\">Sleeps "+ property.sleeps +"</div>\n" +
            "                                    </div>\n" +
            "                                    <div class=\"column\">\n" +
            "                                        <div class=\"ui secondary basic button\">Beds "+ property.beds +"</div>\n" +
            "                                    </div>\n" +
            "                                </div>\n" +
            "                            </div>\n" +
            "                        </div>\n" +
            "                    </div>"
    }
    $('.ui.cards.link').html(html);

}