/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    getUsers();
});



$("form").submit(function(e){
    e.preventDefault();
    $.ajax({
        async: true,
        type: 'POST',
        dataType: 'text',
        data:{
            "msg":$("#msg").val()
        },
        url: "./message/add",
        success: function (data, textStatus, jqXHR) {
            $("#msg").val("");
            getMessages();
        }
        
        
    });
});


function getUsers(){
    $.ajax({
        async: true,
        type: 'GET',
        dataType: 'text',
        url: "./users",
        success: function (data, textStatus, jqXHR) {
            $("#users").empty();
            var liste = $.parseJSON(data);
            $(liste).each(function(e){
                var typ = "";
                if (this.typing == 1){
                    typ = "...";
                }
                if(this.afk == 1){
                 $("#users").append("<p><del>@"+this.email+typ+"</del></p>");   
                }else{
                    
                  $("#users").append("<p>@"+this.email+typ+"</p>");   
                }
            });
            setTimeout(function(){
            getMessages();
        },1000);
        }
        
    });
}

function getMessages(){
    $.ajax({
        async: true,
        type: 'GET',
        dataType: 'text',
        url: "./messages",
        success: function (data, textStatus, jqXHR) {
            $("#messages").empty();
            var liste = $.parseJSON(data);
            $(liste).each(function(e){
                $("#messages").append("<p>"+this.heure.date+"</p><p>@"+this.utilisateur.email+" : "+ this.message+"</p><br/>");
                
            });
            
                $("#messages").animate({ scrollTop: $('#messages').height()+10000}, 1000);
            setTimeout(function(){
            getUsers();
        },1000);
        }
    });
    
    
}
function updateAfk(flag){
    if (flag){
        $.ajax({
        async: true,
        type: 'POST',
        dataType: 'text',
        url: "./user/afk"
    });
        
    }else{
    $.ajax({
        async: true,
        type: 'POST',
        dataType: 'text',
        url: "./user/noafk"        
    });
    }
}
$("body").click(function(){
    updateAfk(false);
    setTimeout(function(){
        updateAfk(true);
    },2000
    );
});
function switchTyping(){
    $.ajax({
        async: true,
        type: 'POST',
        dataType: 'text',
        url: "./user/typing"        
    });
}
$("#msg").focusin(function(){
    switchTyping();
    });
$("#msg").focusout(function(){
    switchTyping();
    });

