$(document).ready(function(){
    
    var path = window.location.pathname;
    
    if(path.indexOf('admin-add-new/add') > 0){
        $(".admin-add-new .first").css("display", "block");
        $(".admin-add-new .second").css("display", "none");
        $(".admin-add-new .query-edition").css("display", "none");        
    }else if(path.indexOf('admin-add-new/top-query-management') > 0){
        $(".admin-add-new .second").css("display", "block");
        $(".admin-add-new .first").css("display", "none");
        $(".admin-add-new .query-edition").css("display", "none");    
    }else if(path.indexOf('admin-add-new/query-edition') > 0){
        $(".admin-add-new .query-edition").css("display", "block");
        $(".admin-add-new .second").css("display", "none");
        $(".admin-add-new .first").css("display", "none");
    }else if(path.indexOf('admin-multiple/register')>0){
        $(".multiple-section .multiple").css("display", "block");
        $(".multiple-section .multiple-choice").css("display", "none");
        $(".multiple-section .multiple-edition").css("display", "none");
    }else if(path.indexOf('admin-multiple/multiple-choice')>0){
        $(".multiple-section .multiple").css("display", "none");
        $(".multiple-section .multiple-choice").css("display", "block");
        $(".multiple-section .multiple-edition").css("display", "none");
    }else if(path.indexOf('admin-multiple/multiple-edition')>0){
        $(".multiple-section .multiple").css("display", "none");
        $(".multiple-section .multiple-choice").css("display", "none");
        $(".multiple-section .multiple-edition").css("display", "block");
    }else if(path.indexOf('admin-choice/register') > 0){
        $(".admin-choice .register").css("display", "block");
        $(".admin-choice .choice-edition").css("display", "none");
        $(".admin-choice .choice-management").css("display", "none");
    }else if(path.indexOf('admin-choice/choice-edition') > 0){
        $(".admin-choice .register").css("display", "none");
        $(".admin-choice .choice-edition").css("display", "block");
        $(".admin-choice .choice-management").css("display", "none");
    }else if(path.indexOf('admin-choice/choice-management') > 0){
        $(".admin-choice .register").css("display", "none");
        $(".admin-choice .choice-edition").css("display", "none");
        $(".admin-choice .choice-management").css("display", "block");
    }else if(path.indexOf('admin-last-template/add') > 0){
        $(".admin-last-template .addition").css("display", "block");
        $(".admin-last-template .management").css("display", "none");
    }else if(path.indexOf('admin-last-template/last-template-management') > 0){
        $(".admin-last-template .addition").css("display", "none");
        $(".admin-last-template .management").css("display", "block");
    }else if(path.indexOf('admin-info/edit') > 0){
        $(".admin-info .top").css("display", "none");
        $(".admin-info .edit").css("display", "block");
        $(".admin-info .confirm-section").css("display", "none");
    }else if(path.indexOf('admin-info/confirm') > 0){
        $(".admin-info .top").css("display", "none");
        $(".admin-info .edit").css("display", "none");
        $(".admin-info .confirm-section").css("display", "block");
    }else if(path.indexOf('admin-account-list/list') > 0){
        $(".admin-account-list .list").css("display", "block");
        $(".admin-account-list .add-new").css("display", "none");
        $(".admin-account-list .account-info").css("display", "none");
        $(".admin-account-list .edition").css("display", "none");
        $(".admin-account-list .account-confirm").css("display", "none");
    }else if(path.indexOf('admin-account-list/add-new') > 0){
        $(".admin-account-list .list").css("display", "none");
        $(".admin-account-list .add-new").css("display", "block");
        $(".admin-account-list .account-info").css("display", "none");
        $(".admin-account-list .edition").css("display", "none");
        $(".admin-account-list .account-confirm").css("display", "none");
    }else if(path.indexOf('admin-account-list/account-info') > 0){
        $(".admin-account-list .list").css("display", "none");
        $(".admin-account-list .add-new").css("display", "none");
        $(".admin-account-list .account-info").css("display", "block");
        $(".admin-account-list .edition").css("display", "none");
        $(".admin-account-list .account-confirm").css("display", "none");
    }else if(path.indexOf('admin-account-list/edition') > 0){
        $(".admin-account-list .list").css("display", "none");
        $(".admin-account-list .add-new").css("display", "none");
        $(".admin-account-list .account-info").css("display", "none");
        $(".admin-account-list .edition").css("display", "block");
        $(".admin-account-list .account-confirm").css("display", "none");
    }else if(path.indexOf('admin-account-list/account-confirm') > 0){
        $(".admin-account-list .list").css("display", "none");
        $(".admin-account-list .add-new").css("display", "none");
        $(".admin-account-list .account-info").css("display", "none");
        $(".admin-account-list .edition").css("display", "none");
        $(".admin-account-list .account-confirm").css("display", "block");
    }else if(path.indexOf('user-part/list') > 0){
        $(".user-part .list").css("display", "block");
        $(".user-part .add-part").css("display", "none");
        $(".user-part .user-info").css("display", "none");
        $(".user-part .edition").css("display", "none");
        $(".user-part .account-confirm").css("display", "none");
    }else if(path.indexOf('user-part/add-part') > 0){
        $(".user-part .list").css("display", "none");
        $(".user-part .add-part").css("display", "block");
        $(".user-part .user-info").css("display", "none");
        $(".user-part .edition").css("display", "none");
        $(".user-part .account-confirm").css("display", "none");
    }else if(path.indexOf('user-part/user-info') > 0){
        $(".user-part .list").css("display", "none");
        $(".user-part .add-part").css("display", "none");
        $(".user-part .user-info").css("display", "block");
        $(".user-part .edition").css("display", "none");
        $(".user-part .account-confirm").css("display", "none");
    }else if(path.indexOf('user-part/edition') > 0){
        $(".user-part .list").css("display", "none");
        $(".user-part .add-part").css("display", "none");
        $(".user-part .user-info").css("display", "none");
        $(".user-part .edition").css("display", "block");
        $(".user-part .account-confirm").css("display", "none");
    }else if(path.indexOf('user-part/account-confirm') > 0){
        $(".user-part .list").css("display", "none");
        $(".user-part .add-part").css("display", "none");
        $(".user-part .user-info").css("display", "none");
        $(".user-part .edition").css("display", "none");
        $(".user-part .account-confirm").css("display", "block");
    }else if(path.indexOf('common-answers/first-step') > 0){
        $(".common .first").css("display", "block");
        $(".common .choose").css("display", "none");
        $(".common .last-step").css("display", "none");
    }else if(path.indexOf('common-answers/choose') > 0){
        $(".common .first").css("display", "none");
        $(".common .choose").css("display", "block");
        $(".common .last-step").css("display", "none");
    }else if(path.indexOf('common-answers/last-step') > 0){
        $(".common .first").css("display", "none");
        $(".common .choose").css("display", "none");
        $(".common .last-step").css("display", "block");
    }else if(path.indexOf('user-answer/first') > 0){
        $(".common .first").css("display", "block");
        $(".common .choose").css("display", "none");
    }else if(path.indexOf('user-answer/choose') > 0){
        $(".common .first").css("display", "none");
        $(".common .choose").css("display", "block");
    }

    
    // change event of select option  
    $('.admin-add-new .query-cat').on('change', function() {
        cat = this.value;
        $('.admin-add-new .query-category-input').val(cat);    
    });
    
    $('.admin-add-new .first .add-answer').click(function(){
        var last_id = $(".first .answer-section .row").last().find("span").text().replace('.', '').trim();
        var id = parseInt(last_id) + 1;        
        $(".first .answer-section").append('<div class="row"><div class="col-md-2 col-sm-2 next"></div><div class="col-md-10 col-sm-10"><span class="id">'+(id)+'. </span><input name="query_answer[]" value="" ></div></div>');
    });   

    // admin question edit
    $(document).on("click", '.admin-add-new .query-edition .add-answer', function(){            
        var last_id = $(".query-edition .answer-section .row").last().find("span").text().replace('.', '').trim();        
        var id = 0;
        if(last_id == ''){
            id = 1;
        }else{
            id = parseInt(last_id) + 1;        
        }
        
        $(".query-edition .answer-section .answer-dynamic").append('<div class="row"><span class="id">'+(id)+'. </span><input class="test" type="text" name="query_answer[]" value=""><span class="del">削除</span></div>');
    });  
    
    $(document).on("click", ".admin-add-new .query-edition .answer-section .answer-dynamic .del", function(event){
        $(event.target).closest(".row").remove();
    });
    $(document).on("click", ".multiple-edition .answer-dynamic .del", function(event){
        $(event.target).closest(".row").remove();
    });

    // multiple 
    $(".multiple .btn-section .add").click(function(){
        $(".multiple .btn-section.up").css("display","none");
        $(".multiple .btn-section.bottom").css("display","flex");
        $(".multiple .answer-section").css("display", "block");
    });

    $(document).on("click", '.multiple .btn-section .add-answer', function(){            
        var last_id = $(".multiple .answer-section .row").last().find("span").text().replace('.', '').trim();
        console.log(last_id);
        
        var id = 0;
        if(last_id == ''){
            id = 1;
        }else{
            id = parseInt(last_id) + 1;        
        }        
        $(".multiple .answer-section").append('<div class="row"><div class="col-md-2 col-sm-2 next"></div><div class="col-md-10 col-sm-10"><span class="sub-id">'+(id)+'. </span><input type="text" name="query_answer[]" value="" required></div></div>');
    });  

    $(document).on("click", '.multiple-edition .btn-section .add-answer', function(){            
        var last_id = $(".multiple-edition .answer-dynamic .row").last().find("span").text().replace('.', '').trim();       
        var id = 0;
        if(last_id == ''){
            id = 1;
        }else{
            id = parseInt(last_id) + 1;        
        }
        
        $(".multiple-edition .answer-dynamic").append('<div class="row"><span class="id">'+(id)+'. </span><input class="test" type="text" name="query_answer[]" value=""><span class="del">削除</span></div>');
    });  

    // admin-choice
    $(document).on("click", ".admin-choice .btn-section .add", function(){        
        //var query_index = $(".admin-choice .query-section .row").last().find("span").text();
        var param = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        var query_index = $('.query-section input[name="alternative_num[]"]:last').val();
        query_index = parseInt(query_index) + 1;

        //if(query_index == "B"){
        //    alert("You already added next query 'B'.");
        //}else{
            $(".admin-choice .register .query-section").append('<div class="row"><div class="col-md-2 col-sm-2">質問内容</div><div class="col-md-10 col-sm-10"><span>'+param[query_index]+'</span><input name="alternative_num[]" value="'+query_index+'" hidden><textarea type="text" name="query_content[]" rows="1" value="" required></textarea></div></div>');

            $('.admin-choice textarea').bind('input propertychange', function() {
                var enteredText = this.value;
                var numberOfLineBreaks = (enteredText.match(/\n/g)||[]).length;
                numberOfLineBreaks += 1;
                $(this).attr("rows", numberOfLineBreaks);
            });
        //}
    });

    $('.admin-choice textarea').bind('input propertychange', function() {
        var enteredText = this.value;
        var numberOfLineBreaks = (enteredText.match(/\n/g)||[]).length;
        numberOfLineBreaks += 1;
        $(this).attr("rows", numberOfLineBreaks);
    });
    
    $('.admin-choice .choice-edition .add-last-template').click(function(){
        $('.admin-choice .btn-section').css('display', 'none');
        $('.admin-choice .choice-edition .last-template').css('display', 'block');
    });

    $('.admin-choice .query-cat').on('change', function() {
        cat = this.value;
        $('.admin-choice .last-template-selected').val(cat);
    });
    $('.admin-account-list .permission').on('change', function() {
        var permission = this.value;
        $('.admin-account-list .input-permission').val(permission);
    });
    
    $(".admin-choice .choice-management .last-template-manage .run").click(function(){
        $(".admin-choice .choice-management .last-template-manage .btn-one").css("display", "none");
        $(".admin-choice .choice-management .last-template-manage .btn-two").css("display", "block");
    });

    /////////////////////////// admin info /////////////////////
    $(".toggle-password").click(function(){
        var type = $(".password").attr('type');
        if (type === "password") {
            $(".password").attr('type', 'text');
        } else {    
            $(".password").attr('type', 'password');
        }

        if($("#eye-img").attr('class') == 'eye-img'){
            $("#eye-img").addClass('none');
            $("#eye-img img").attr('src', '../public/assets/images/password_eye_none.png');
        }else{            
            $("#eye-img").attr('class', 'eye-img');
            $("#eye-img img").attr('src', '../public/assets/images/password_eye.png');
        }
    });
    $(".admin-account-list .list .store-manager").click(function(){
        $(".admin-account-list .list .store-manager").css('background', '#ddd');
        $(".admin-account-list .list .users").css('background', '#fff');

        $(".admin-account-list .list .store-section").css("display", "table-row");
        $(".admin-account-list .list .users-section").css("display", "none");
    });
    $(".admin-account-list .list .users").click(function(){
        $(".admin-account-list .list .store-manager").css('background', '#fff');
        $(".admin-account-list .list .users").css('background', '#ddd');

        $(".admin-account-list .list .store-section").css("display", "none");
        $(".admin-account-list .list .users-section").css("display", "table-row");
    });

});
