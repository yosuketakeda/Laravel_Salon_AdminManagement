@include('include/header-admin')

<div class="admin-add-new">    
    <div class="container">
        <div class="first"><!-- top add -->            
            <form action="{{route('admin_top_add.first')}}" method="POST">
                @csrf
                <input name="type" value="{{$type}}" hidden>
                <div class="card-header">
                    @if($type == 2) 
                    店舗
                    @endif
                    TOP質問 &nbsp;&nbsp;&nbsp; 編集</div>
                <p class='title'>質問内容</p>
                <div class="answer-section">
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            ID
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <span class="new-id">{{$id}}</span>
                            <input name = "query_id" value="{{$id}}" hidden>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            カテゴリー
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <select class="query-cat" disabled>
                                <option value="1" {{$type == 1 ? 'selected' : ''}}>サロン顧客用</option>
                                <option value="2" {{$type == 2 ? 'selected' : ''}}>サロンオーナー用</option>
                            </select>
                            <input class="query-category-input" type='text' name="first_category" value="{{$type}}" hidden>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            質問内容
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <input type="text" name="query_content" value="" required> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            答え
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <span>1. </span><input name="query_answer[]" value="" required> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2 next">
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <span>2. </span><input name="query_answer[]" value="" >
                        </div>
                    </div>
                </div>
                <input id="answers" name="answers" hidden>
                <div class="btn-section">
                    <span class="add-answer">答えを追加</span>
                    <button type="submit" class="run">登録</button>
                </div>
            </form>
        </div><!-- first == top add -->
        
        <div class="second"><!-- top query management -->
            <div class="card-header">
                @if($type == 2) 
                店舗
                @endif
                TOP質問管理</div>
            <p class='title'>質問内容</p>
            <input class="query-id" value="{{empty($query) ? 1 : $query[0]->id}}" hidden>
            <div class="row">
                <div class="col-md-2 col-sm-2">
                    ID
                </div>
                <div class="col-md-10 col-sm-10">
                    <div class="col-md-3 col-sm-3">
                        <span class="new-id">{{empty($query) ? 1 : $query[0]->Qnum}}</span>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <a href="{{route('admin_add_new.index', ['step'=>'query-edition', 'type'=>$type, 'transID'=>empty($query) ? 1 : $query[0]->id])}}" class="query-edit">質問内容の編集</a>
                        <span class="query-delete">質問の削除</span>
                    </div>
                </div>         
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-2">
                    カテゴリー
                </div>
                <div class="col-md-10 col-sm-10">
                    <span class="selected-cat">{{empty($query) ? '' : $query[0]->type == 1 ? 'サロン顧客用' : 'サロンオーナー用'}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-2">
                    質問内容
                </div>
                <div class="col-md-10 col-sm-10">
                    <span class="selected-query">{{empty($query) ? "Nothing" : $query[0]->query_content}}</span> 
                </div>
            </div>            
            <div class="table-section">
                <table>
                    <th>ID</th>
                    <th>答え</th>
                    <th>登録日時</th>
                    <th>操作</th>
                    @if(!empty($query))
                        @foreach($answer as $each)
                        <tr>
                            <td><input class="id" value="{{$each->id}}" hidden>
                            <?php
                                $Aid = $each->id;
                                $result = '';
                                while(1){
                                    $a_buf = DB::table('answer')->where('id', $Aid)->get();
                                    $buf = $a_buf[0]->Anum; //// last num
                                    $result = $buf.'-'.$result;
                                    $Qid = $a_buf[0]->Qid;
                                    $q_buf = DB::table('query')->where('id', $Qid)->get();
                                    $buf = $q_buf[0]->Aid;
                                    if($buf == '0'){
                                        $result = $q_buf[0]->Qnum.'-'.$result;
                                        break;
                                    }else{
                                        $Aid = $buf;
                                    }
                                }        
                                $result = substr($result, 0, -1);
                                echo $result;
                            ?>
                            </td>
                            <td>
                                <?php                                     
                                    $mul= DB::table('query')->where('Aid', $each->id)->get();
                                    if(count($mul) == 0){?>
                                        {{$each->answer_content}}
                                <?php 
                                    }else{ 
                                        $mul_q_id = $mul[0]->id;
                                        $choi = DB::table('query')->where('Aid', $each->id)->where('Qnum', 0)->get();
                                        if(count($choi) != 0){ ?>
                                            <a href="{{route('admin_choice.index', ['step' => 'choice-edition', 'type'=>$type,'query_id'=>$each->Qid, 'answer_id'=>$each->id, 'category'=>$query[0]->category] )}}">{{$each->answer_content}}</a>
                                <?php   }else{
                                        ?>
                                            <a href="{{route('admin_multiple.index', ['step' => 'multiple-choice', 'type'=>$type,'query_id'=>$mul_q_id, 'answer_id'=>$each->id, 'category'=>$query[0]->category] )}}">{{$each->answer_content}}</a>
                                <?php   
                                        }
                                    }
                                ?>                                
                            </td>
                            <td>{{str_replace('-', '/', explode(' ', $each->created_at)[0])}}</td>
                            <td>
                                <?php 
                                    $mul= DB::table('query')->where('Aid', $each->id)->get();                                    
                                    if(count($mul) == 0){?>
                                        <a href="{{route('admin_multiple.index', ['step'=>'register', 'type'=>$type, 'query_id'=>$each->Qid, 'answer_id'=>$each->id, 'category'=>$query[0]->category ] )}}" class="edit">編集</a>                                        
                                <?php 
                                    }else{
                                        $choi = DB::table('query')->where('Aid', $each->id)->where('Qnum', 0)->get();
                                        if(count($choi) != 0){ ?>
                                            <a href="{{route('admin_choice.index', ['step' => 'register', 'type'=>$type,'query_id'=>$each->Qid, 'answer_id'=>$each->id, 'category'=>$query[0]->category] )}}" class="edit">編集</a>
                                <?php
                                        }else{
                                        ?>
                                            <a href="{{route('admin_multiple.index', ['step' => 'multiple-edition', 'type'=>$type,'query_id'=>$mul_q_id, 'answer_id'=>$each->id, 'category'=>$query[0]->category] )}}" class="edit">編集</a>
                                <?php 
                                        }
                                    }
                                ?>
                                <span class="delete">削除</span>
                            </td>
                        </tr>
                        @endforeach
                    @endif                        
                </table>
            </div>
            <div class="return-dashboard">
                <a class="btn-action"  href="{{route('admin_dashboard.index')}}">管理メニューに戻る</a>
            </div>            
        </div><!-- second = top query management -->
        
        <div class='query-edition'>
            <div class="card-header">
                @if($type == 2) 
                店舗
                @endif
                TOP質問 &nbsp;&nbsp;&nbsp; 編集
            </div>
            <p class='title'>質問内容</p>
            <form action="" method="POST" id="edition-form">
                @csrf
                <div class="answer-section">
                    <input name="type" value="{{$type}}" hidden>
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            ID
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <span class="new-id">{{empty($query) ? 1 : $query[0]->Qnum}}</span>
                            <input type="text" name="query_id" value="{{$query_id}}" hidden>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            カテゴリー
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <select class="query-cat" disabled>
                                <option {{empty($query)? '' : $query[0]->type == 1 ? 'selected' : '' }} value="1">サロン顧客用</option>
                                <option {{empty($query)? '' : $query[0]->type == 2 ? 'selected' : '' }} value="2">サロンオーナー用</option>
                            </select>
                            <input type="text" class="query-category-input" name="edition_category" value="{{empty($query)? '' : $query[0]->type}}" hidden>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            質問内容
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <input class="query-content" type="text" name="query_content" value="{{empty($query)? '' : $query[0]->query_content}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2 answer-col-2">                               
                            <div class="row answer-name">答え</div>                            
                        </div>
                        <div class="col-md-10 col-sm-10 answer-dynamic">
                            @if(!empty($answer))
                                <?php $i = 1;?>
                                @foreach($answer as $each)
                                <div class="row">
                                    <span class="id"><?php echo $i;?>. </span>
                                <input type="text" data-id="{{$each->id}}" name="query_answer[]" value="{{$each->answer_content}}"> 
                                    <span class="del">削除</span>
                                </div>    
                                <?php $i++; ?>
                                @endforeach
                            @else 
                                <div class="row">
                                    <span class="id">1. </span>
                                    <input type="text" name="query_answer[]" value=""> 
                                    <span class="del">削除</span>
                                </div>    
                            @endif
                        </div>
                    </div>
                </div>
                <div class="btn-section">
                    <span class="add-answer">答えを追加</span>
                    <input type="submit" class="run" value="登録">
                </div>
            </form>
        </div><!-- query edition -->         
             
    </div><!-- container -->
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
        //console.log(query_id+"::"+type+"::"+table_id+"::"+return_mode);
        
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
   
    $(document).on("click", ".admin-add-new .query-edition .btn-section .run", function(event){
        event.preventDefault();

        var data = new Object();
        data.query_id = $("#edition-form input[name='query_id']").val();
        data.category = $("#edition-form input[name='edition_category']").val();
        data.query_content = $("#edition-form input[name='query_content']").val();
        data.type = $("#edition-form input[name='type']").val();
        var answer_array = new Array();
        $(document).find("#edition-form input[name='query_answer[]']").each(function(i, input){
            var answer = new Object();
            if($(this).val().trim() != ''){
                if( typeof $(this).data('id') === "undefined"){
                    answer.id = 0;                
                }else{
                    answer.id = $(this).data('id');
                }                        
                answer.query_content = $(this).val();
                answer_array.push(answer);
            }            
        });

        if(answer_array.length === 0){
        
            alert("You must entry minimal one answer.");
        
        }else{
            data.answers = answer_array;
        
            $.ajax({
                url: "{{route('admin_top.edition')}}",
                type: "POST",
                data: {"data": data},
                success: function (data) {                
                    if(data.success){
                        console.log("Successed!");                             
                        location.reload();
                    }else{
                        console.log("Failed!");                    
                    }
                },
                error: function(data) {
                    console.log("Errors!!");
                }
            });
        }
        
    });

    $(".admin-add-new .second .query-delete").click(function(event){
        var query_id = $(".admin-add-new .second .query-id").val();
        console.log(query_id);
        $("#dialog-warning").css("display", "block");     
        $("#dialog-warning .del-id").val(query_id);
        $("#dialog-warning .type").val('{{$type}}');
        $("#dialog-warning .table-id").val('2');  // answer
        $("#dialog-warning .return-mode").val('dashboard');
    });

    $(".admin-add-new .second .table-section .delete").click(function(event){   
        var query_id = $(event.target).closest("tr").find(".id").val();       

        $("#dialog-warning").css("display", "block");     
        $("#dialog-warning .del-id").val(query_id);
        $("#dialog-warning .type").val('{{$type}}');
        $("#dialog-warning .table-id").val('1');  // answer
        $("#dialog-warning .return-mode").val('reload');
    });
});
</script>