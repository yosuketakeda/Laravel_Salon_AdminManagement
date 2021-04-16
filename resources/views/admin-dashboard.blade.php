@include('include/header-admin')

<div class="admin-dashboard">
    <div class="container">
        <div class="card-header">質問管理メニュー</div>
        <div class="top">
            <div class="title">TOP質問　一覧</div>
            <div class="intro">                
                <a class="add-new" href="{{route('admin_add_new.index', ['step'=>'add', 'type'=>'1'])}}">新規登録</a>
            </div>
            <div class="table-section">
                <table>
                    <th>ID</th>
                    <th>質問内容</th>
                    <th>登録日時</th>
                    <th>操作</th>
                    @foreach($query as $each)    
                        @if($each->type == '1')
                        <tr>                            
                            <td>{{$each->Qnum}}<input id="query_id" value="{{$each->id}}" hidden></td>
                            <td><a href="{{route('admin_add_new.index', ['step' => 'top-query-management', 'type'=>'1', 'transID'=>$each->id])}}">{{$each->query_content}}</a></td>
                            <td>{{str_replace('-','/',explode(' ', $each->created_at)[0])}}</td>
                            <td>                            
                                <a href="{{route('admin_add_new.index', ['step'=>'query-edition', 'type'=>'1', 'transID'=>$each->id])}}" class="edit">編集</a>
                                <a href="javascript:void(0);" class="delete">削除</a>
                            </td>
                        </tr>
                        @endif                   
                    @endforeach 
                </table>
            </div>
        </div> <!-- each term -->
        <div class="store">
            <div class="title">店舗TOP質問　一覧</div>
            <div class="intro">
                <a class="add-new" href="{{route('admin_add_new.index', ['step'=>'add', 'type'=>'2'])}}">新規登録</a>
            </div>
            <div class="table-section">
                <table>
                    <th>ID</th>
                    <th>質問内容</th>
                    <th>登録日時</th>
                    <th>操作</th>
                    @foreach($query as $each)    
                        @if($each->type == '2')
                        <tr>                            
                            <td >{{$each->Qnum}}<input id="query_id" value="{{$each->id}}" hidden></td>
                            <td><a href="{{route('admin_add_new.index', ['step' => 'top-query-management', 'type'=>'2', 'transID'=>$each->id])}}">{{$each->query_content}}</a></td>
                            <td>{{str_replace('-','/',explode(' ', $each->created_at)[0])}}</td>
                            <td>                            
                                <a href="{{route('admin_add_new.index', ['step'=>'query-edition', 'type'=>'2', 'transID'=>$each->id])}}" class="edit">編集</a>
                                <a href="javascript:void(0);" class="delete">削除</a>
                            </td>
                        </tr>
                        @endif                   
                    @endforeach 
                </table>
            </div>
        </div><!-- each term -->
        <div class="last">
            <div class="title">最後の質問テンプレート一覧</div>
            <div class="intro">
                <a class="add-new" href="{{route('admin_last_template.index', ['step'=>'add'])}}">新規登録</a>
            </div>
            <div class="table-section">
                <table>
                    <th>ID</th>
                    <th>最後質問テンプレート</th>
                    <th>登録日時</th>
                    <th>操作</th>
                    @if(!empty($last_template))
                        @foreach($last_template as $template)
                        <tr>                            
                            <td>F-{{$template->template_id}}<input id="query_id" value="{{$template->id}}" hidden></td>
                            <td><a href="{{route('admin_last_template.index', ['step'=>'last-template-management', 'template_id'=>$template->template_id, 'mode'=>'edition'])}}">{{$template->template_query}}</a></td>
                            <td>{{explode(' ', $template->created_at)[0]}}</td>
                            <td>
                                <a href="{{route('admin_last_template.index', ['step'=>'add', 'template_id'=>$template->template_id, 'mode'=>'edition'])}}" class="edit">編集</a>
                                <a href="javascript:void(0);" class="delete">削除</a>
                                <input class="last_id" value="{{$template->template_id}}" hidden>
                            </td>
                        </tr>                    
                        @endforeach
                    @endif
                </table>
            </div>
        </div><!-- each term -->        
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
            <input class="type" value="" hidden>
            <input class="table-id" value="" hidden>
            <input class="return-mode" value="" hidden>
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
        var query_id = $("#dialog-warning .del-id").val();
        var type = $("#dialog-warning .type").val();
        var table_id = $("#dialog-warning .table-id").val();
        var return_mode = $("#dialog-warning .return-mode").val();
        
        $.ajax({
            url: "{{route('admin_top_query.delete')}}",
            type: "POST",
            data: {"query_id":query_id, "type": type, "table_id":table_id, "return_mode":return_mode },
            success: function (data) {        
                if(data.success){
                    console.log("Successed!");          
                    if(data.return_mode == 'reload'){
                        location.reload();
                    }else if(data.return_mode == 'dashboard'){
                        window.location.href = "{{route('admin_dashboard.index')}}";
                    }
                    
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
    $(".admin-dashboard .top .table-section .delete").click(function(event){
        $("#dialog-warning").css("display", "block");
        var query_id = $(event.target).closest("tr").find("#query_id").val();
        $("#dialog-warning .del-id").val(query_id);
        $("#dialog-warning .type").val('1');
        $("#dialog-warning .table-id").val('2');  // query
        $("#dialog-warning .return-mode").val('dashboard');
    });    
    $(".admin-dashboard .store .table-section .delete").click(function(event){
        $("#dialog-warning").css("display", "block");
        var query_id = $(event.target).closest("tr").find("#query_id").val();
        $("#dialog-warning .del-id").val(query_id);
        $("#dialog-warning .type").val('2');
        $("#dialog-warning .table-id").val('2'); // query
        $("#dialog-warning .return-mode").val('dashboard');
    });
    $(".admin-dashboard .last .table-section .delete").click(function(event){
        $("#dialog-warning").css("display", "block");
        var template_id = $(event.target).closest("tr").find(".last_id").val();
        console.log(template_id);
        $("#dialog-warning .del-id").val(template_id);
        $("#dialog-warning .type").val('3');
        $("#dialog-warning .table-id").val('2'); // query
        $("#dialog-warning .return-mode").val('dashboard');
    });
});
</script>