
function display_error(message) {
    $('#error_message').text(message);
    $('#error_box').dialog('open');
}

function setcapitol() {
    $('.capitol').autocomplete({
        minLength: 2,
        source: 'app_dev.php/search', // NOTE: change later
        select: function( event, ui ) {
            var build = '';
            var exit = false;

            // check to see if the (a) there are less than 7 capitols
            if($('.capitol_box').length >= 6) {
                // 6 player game, max
                display_error('Cannot have more than 6 capitols');
                return;
            }
           
            $('input[name="capitol[]"]').each(function(index){
                // (b) capitol has already been selected
                if($(this).val() == ui.item.label) {
                    display_error('Capitol is already in use');
                    exit = true;
                    return;
                }

                // (c) capitol is not in an empire already selected
                if($(this).attr('data-id') == ui.item.id) {
                    display_error('There can only be one capitol per empire');
                    exit = true;
                    return;
                }
            });

            if(exit === true) {
                return;
            }

            // if it passes all checks, add it to the list
            build  = '<div class="capitol_box empire';
            build += ui.item.id + '" data-id="' + ui.item.id + '">';
            build += ui.item.label + '<div class="remove_capitol"><a href="#" class="remove_capitol">x</a>';
            build += '<input type="hidden" name="capitol[]" data-id="' + ui.item.id + '" value="';
            build += ui.item.label + '" /></div></div>';
            $('#selected').append(build);
        }
    });
}

$('#form_randomize').on('click', function(){
    console.log('click');
    $('#distributed').load('app_dev.php/distribute?' + $('input[name="capitol[]"]').serialize());
    $('#distrubted').show();
});

$('a.remove_capitol').on('click', function() {
    $(this).parent().parent().remove();
});

setcapitol();

// initialize the error box to be hidden, remove the x, and add a button instead
$('#error_box').dialog({
    modal: true,
    buttons: [{
        text: "OK",
        click: function() {
            $( this ).dialog( "close" );
        }
    }],
    dialogClass: "no-close",
    autoOpen: false
}).create;