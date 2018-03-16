$(function () {
    $("select").change(function () {
        var type = this.value;
        if(type == "limitted") {
            $("#date").removeProp("hidden");

        } else {
            $("#date").prop("hidden", "hidden");
        }
    });
    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $("#Oczekiwanienapłatność").css('background-color', '#caebfb');
    $("#Płatnośćzaakceptowana").css('background-color', '#ddffa6');
    $("#Anulowane").css('background-color', '#f6c1c1');

    $("select[name=groupcodes]").change(function () {
        var val = this.value;
        console.log(val);
        if(val == "newgroup") {
            $("#addgroupcodes").removeProp("hidden");
            $("#addDiscountCode").attr("disabled",true);

        } else {
            $("#addgroupcodes").prop("hidden", "hidden");
            $("#addDiscountCode").attr("disabled",false);
        }
    });

    $(".checkmethod").change(function () {
       if($('#choosediscount').is(":checked")) {
           $('#chooseprices').prop("checked", false);
           $('#discount').prop("hidden", false);
       } else {
           $('#discount').prop("hidden", true);
       }
        if($('#chooseprices').is(":checked")) {
            $('#choosediscount').prop("checked", false);
            $('#prices').prop("hidden", false);
        } else {
            $('#prices').prop("hidden", true);
        }
    });
//*************************************************************
    var $rows = $('#ordersTable tbody tr');
    $('#liveSearch').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });

    //**************************
    var $rows2 = $('#usersTable tbody tr');
    $('#liveSearch2').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows2.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
    //*****************************
    var url = window.location;
    $('ul.nav a[href="'+ url +'"]').parent().addClass('active');
    $('ul.nav a').filter(function() {
        return this.href == url;
    }).parent().addClass('active');
});
