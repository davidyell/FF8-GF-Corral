$(function () {
    
    $('select.select-character').change(function (e) {
        e.preventDefault();
        var character = $(this).children('option:selected').val();
        
        if (character === 'Select character') {
            $(this).parents('tr').find('td img.junctioned').parents('td').html("<i class='glyphicon glyphicon-ok'></i>");
        } else {
            $(this).parents('tr').find('td i.glyphicon').parents('td').html("<img class='junctioned' src='/assets/images/" + character + ".png'>");
            $(this).parents('tr').find('td img.junctioned').parents('td').html("<img class='junctioned' src='/assets/images/" + character + ".png'>");
        }
    });
    
});