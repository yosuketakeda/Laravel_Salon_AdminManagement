@include('include/header-admin')

<div class="admin-last-template">
    <div class="container">
        <div class="addition">
            <form action="{{route('admin_last_template.add')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input name="mode" value="{{$mode}}" hidden>
                <div class="card-header">最後の質問 &nbsp;&nbsp;&nbsp; 編集</div>
                <p class='title'>質問内容</p>
                <div class="answer-section">
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            ID
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <span class="new-id">F-{{empty($template)? $template_id : $template[0]->template_id}}</span>
                            <input name="template_id" value="{{empty($template)? $template_id : $template[0]->template_id}}" hidden>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            テンプレート名
                        </div>
                        <div class="col-md-10 col-sm-10">                            
                            <input type='text' name="template_name" class="template-name" value="{{empty($template)? '' : $template[0]->template_name}}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            質問内容
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <input type="text" name="query_content" class="query-content" value="{{empty($template)? '' : $template[0]->template_query}}" required> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            案内チラシ登録
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <label class="refer">参照
                                <input type="file" value="" name="filename" class="upload-file" style="opacity: 0; width: 1px; padding: 0" >                                
                            </label>
                            <span class="file-name"></span>
                            <input type="text" value="" name="real_name" id="real_name" hidden>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            Webサイトのリンク
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <input type="text" name="web_url" id="web-url" value="{{empty($template)? '' : $template[0]->web_url}}">
                        </div>
                    </div>                    
                </div>
                <div class="btn-section">
                    <button type="submit" class="run">登録</button>
                </div>
            </form>
        </div><!----------------- last template edition -------------------->
        <div class="management">
            <div class="card-header">最後の質問 &nbsp;&nbsp;&nbsp; 管理</div>
            <p class='title'>質問内容</p>
            <div class="answer-section">
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        ID
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <span class="new-id">F-{{empty($template)? $template_id : $template[0]->template_id }}</span>
                        <input class="template-id" name="template_id" value="{{ empty($template)? $template_id : $template[0]->template_id }}" hidden>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        テンプレート名
                    </div>
                    <div class="col-md-10 col-sm-10">                            
                        <span>{{empty($template)? '' : $template[0]->template_name }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        質問内容
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <span>{{empty($template)? '' : $template[0]->template_query }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        案内チラシ登録
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <span>{{empty($template)? '' : $template[0]->refer_file }}</span>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        Webサイトのリンク
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <span>{{empty($template)? '' : $template[0]->web_url}}</span>
                    </div>
                </div>                    
            </div>
            <div class="btn-section">
                <div style="margin-left: 50%; display: flex">
                    @if(!empty($template))
                    <a href="{{route('admin_last_template.index', ['step'=>'add', 'template_id'=>$template[0]->template_id, 'mode'=>'edition'])}}" class="edit-template">編集</a>
                    @endif
                    <span class="delete">削除</span>
                </div>                
            </div>
        </div><!----------------- last template management -------------------->
    </div>
    <div id="dialog-warning">
        <div class="body">
            <p> この投稿内容を削除しますか？ </p>
            <p> この投稿内容を削除すると、この投稿内容に関連付けられているすべての内容が失われます。 </p>
            <div class="btn-section">
                <button class="del-ok">OK</button>    
                <button class="del-cancel">Cancel</button>
            </div>
            <input class="del-id" value="" hidden>           
        </div>
    </div>
</div>

@include('include/footer')

<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#dialog-warning .del-ok").click(function(){
        $("#dialog-warning").css("display", "none");
        var template_id = $("#dialog-warning .del-id").val();
                
        $.ajax({
            url: "{{route('admin_last_template.delete')}}",
            type: "POST",
            data: {"template_id":template_id },
            success: function (data) {                
                if(data.success){
                    console.log("Successed!");                    
                    window.location.href = "{{route('admin_dashboard.index')}}";
                }else{
                    console.log("Upload Failed!");                    
                }
            },
            error: function(data) {
                console.log("Errors!!");
            }
        });
    });
    $("#dialog-warning .del-cancel").click(function(){
        $("#dialog-warning").css("display", "none");        
    });
    
    $(".admin-last-template .management .delete").click(function(){
        $("#dialog-warning").css("display", "block");
        var template_id = $(".admin-last-template .management .template-id").val();
        console.log(template_id);
        $("#dialog-warning .del-id").val(template_id);        
    });

// input file upload event
    $(".refer input[type=file]").on('change', function(){
        var file = $(this).val();        
        var file_name = file.split('\\')[2];
        $(".file-name").text(file_name);
        $("#real_name").val(file_name);
        $('#web-url').val('');
        $('#web-url').prop('disabled', true);
    });

// web url input event
    $('#web-url').on('input', function() {
        $('.refer input[type=file]').prop('disabled', true);  
        $('.refer input[type=file]').val('');
        $(".file-name").text('');
        $("#real_name").val('');  
        $('.refer').css('background', '#aaa');
    });
});
</script>
