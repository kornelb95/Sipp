$(function () {
    // $('select').firstChild().prop('selected', 'selected');
    $('select option:selected').each(function () {
        console.log(this);
        $("#cenapojemnosc" + this.id).text(this.value + " zł");
    });
    // $.each(selected).text(this.value + " zł");
    // $("#cena" + id).text(this.value + " zł");
    $("select").change(function () {
        // $('select #pojemnosc').firstChild().removeProp('selected');
        var id = this.id;
        $("#cena" + id).text(this.value + " zł");

    });
    var url = window.location;
    $('ul.nav a[href="'+ url +'"]').parent().addClass('active');
    $('ul.nav a').filter(function() {
        return this.href == url;
    }).parent().addClass('active');

    var url = window.location;
    $('ul.categories-list a[href="'+ url +'"]').children().addClass('active');
    $('ul.categories-list a').filter(function() {
        return this.href == url;
    }).children().addClass('active');

    $('.priceRadio:first').addClass('active');
    $('.priceOption:first').prop('checked', 'checked');
    var checkedVal = $('.priceOption:checked').attr('id');
    $('#cenapojemnosc').text(checkedVal + ' zł');

    $('.priceRadio').change(function () {
        $(this).addClass('active');
        var val = $(this).children().attr('id');
        console.log(val);
        $('#cenapojemnosc').text(val + ' zł');
    });


    var howManyLimitted =  $('#carouselCounter').text();
    console.log(howManyLimitted);
    if(howManyLimitted == 1) {
        $('#carouselLimittedContainer').addClass('col-lg-offset-4');
    } else if(howManyLimitted == 2) {
        $('#carouselLimittedContainer').addClass('col-lg-offset-2');
    }

});