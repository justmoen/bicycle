let specifications = {
    init: function() {
        $.ajax({
            type: "POST",
            url: route,
            contentType: 'application/json',
            data: JSON.stringify({
                frontId: $('[id*="_frontDerailleur"] option:selected').val(),
                rearId: $('[id*="_rearDerailleur"] option:selected').val()
            }),
            success: function(response) {
                console.log(response);
            },
            error: function(response) {
                console.log(response);
            }
        });
    }
};
$(document).ready(function() {
    specifications.init();
});