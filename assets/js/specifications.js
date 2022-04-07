let specifications = {
    init: function() {
        this.updateGears();
        $('[id*="_rearDerailleur"], [id*="_frontDerailleur"]').on('change',function(){specifications.updateGears();});
    },
    updateGears: function() {
        $.ajax({
            type: "POST",
            url: route,
            contentType: 'application/json',
            data: JSON.stringify({
                frontId: $('[id*="_frontDerailleur"] option:selected').val(),
                rearId: $('[id*="_rearDerailleur"] option:selected').val()
            }),
            success: function(data) {
                $('[id="speed"]').html(data.numberOfGearCombinations);
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