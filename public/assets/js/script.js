/*!
* Start Bootstrap - Simple Sidebar v6.0.5 (https://startbootstrap.com/template/simple-sidebar)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-simple-sidebar/blob/master/LICENSE)
*/
// 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});



$('.btn').click(function () {
    var id = this.value;    
    var fruitId = $(this).attr("data-fruitid");
    var datastring = {
        "id" : id,
        "fruitId" : fruitId
    };
        $.ajax({
            type: "get",
            url: 'addFavourite',
            // dataType: "json",
            data: datastring,
            success: function (response) {
                if(response=="ADDED"){
                    $("#"+id).attr("class","btn starblue");
                } else {
                    $("#"+id).removeClass("starblue");
                }
            }
        });
});

$('#searchBtn').click(function () {
    var value = $('#search').val();
       var data = {
        "findValue" : value
    };
    $.ajax({
        type: "get",
        url: 'listing',
        // dataType: "json",
        data: data,
        success: function (response) {
            if(response){
                console.log("btn starblue");
            } else {
                console.log("starblue");
            }
        }
    });
});

$("button").click(function () {
    $("p").toggleClass("active");
});