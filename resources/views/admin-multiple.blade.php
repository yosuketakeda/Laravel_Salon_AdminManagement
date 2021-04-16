@include('include/header-admin')

<div class="multiple-section">
    <div class="container"> 
        @if($step == 'register')       
        <div class="multiple"> <!--- new register --->
            <form action="{{route('admin_multiple.add')}}" method="POST">
                @csrf
                <div class="card-header">質問 &nbsp;&nbsp;&nbsp; 編集</div>
                <p class='title'>質問内容</p>
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        ID
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <span class="new-id-multiple">{{$result}}</span>
                        <span>答え ： {{$parent_answer}}</span>
                    </div>
                    <input type="text" name="type" value="{{$type}}" hidden>
                    <input type="text" name="query_id" value="{{$query_id}}" hidden>
                    <input type="text" name="answer_id" value="{{$answer_id}}" hidden>
                    <input type="text" name="category" value="{{$category}}" hidden>
                </div>
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        質問内容
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <input type="text" name="query_content" value="" required>
                    </div>
                </div>     
                <div class="answer-section">
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            答え
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <span class="sub-id">1. </span>
                            <input type="text" name="query_answer[]" value="" required>
                        </div>
                    </div>     
                </div>       
                <div class="btn-section up">
                    <div style="margin:auto; display: flex">
                        <span class="add">複数選択で答えを追加</span>
                        <a class="link-choice" href="{{route('admin_choice.index',['step'=>'register', 'type'=>$type, 'query_id'=>$query_id, 'answer_id'=>$answer_id, 'category'=>$category])}}">２択で答えを追加</a>
                    </div>
                </div>
                <div class="btn-section bottom">
                    <span class="add-answer">答えを追加</span>
                    <button type="submit" class="run">登録</button>
                </div>
            </form>
        </div><!--------- end of new register ---------->
        @endif
        @if($step == 'multiple-choice')
        <div class="multiple-choice">
            <div class="card-header">質問管理</div>
            <input name="type" value="{{$type}}" hidden>
            <div class="row">
                <div class="col-md-5 col-sm-5">
                    質問内容
                </div>
                <div class="col-md-7 col-sm-7">                    
                    <a class="query-edit" href="{{route('admin_multiple.index', ['step' => 'multiple-edition', 'type'=>$type,'query_id'=>$query->id, 'answer_id'=>$answer_id, 'category'=>$category] )}}">質問内容の編集</a>
                    <span class="query-delete">質問の削除</span>
                </div>                
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-2">
                    ID
                </div>
                <div class="col-md-10 col-sm-10">
                <span class="new-id-multiple">{{$result}}</span>
                    <span>答え ： {{$parent_answer}}</span>
                </div>
            </div>            
            <div class="row">
                <div class="col-md-2 col-sm-2">
                    質問内容
                </div>
                <div class="col-md-10 col-sm-10">
                    <span class="selected-query">{{$query->query_content}}</span> 
                </div>
            </div>            
            <div class="table-section">
                <table>
                    <th>ID</th>
                    <th>答え</th>
                    <th>登録日時</th>
                    <th>操作</th>
                    @if(!empty($child_answer))                   
                        @foreach($child_answer as $answer)
                        <tr>
                            <td><input class="id" value="{{$answer->id}}" hidden>
                            <?php
                                $Aid = $answer->id;
                                $cus_result = '';
                                while(1){
                                    $a_buf = DB::table('answer')->where('id', $Aid)->get();
                                    $buf = $a_buf[0]->Anum; //// last num
                                    $cus_result = $buf.'-'.$cus_result;
                                    $Qid = $a_buf[0]->Qid;
                                    $q_buf = DB::table('query')->where('id', $Qid)->get();
                                    $buf = $q_buf[0]->Aid;
                                    if($buf == '0'){
                                        $cus_result = $q_buf[0]->Qnum.'-'.$cus_result;
                                        break;
                                    }else{
                                        $Aid = $buf;
                                    }
                                }        
                                $cus_result = substr($cus_result, 0, -1);
                                echo $cus_result;
                            ?>
                            </td>
                            <td>
                                <?php 
                                    $mul= DB::table('query')->where('Aid', $answer->id)->get();
                                    if(count($mul) == 0){?>
                                        {{$answer->answer_content}}
                                <?php 
                                    }else{ 
                                        $mul_q_id = $mul[0]->id;
                                        $choi = DB::table('query')->where('Aid', $answer->id)->where('Qnum', 0)->get();
                                        if(count($choi) != 0){ ?>
                                            <a href="{{route('admin_choice.index', ['step' => 'choice-edition', 'type'=>$type,'query_id'=>$answer->Qid, 'answer_id'=>$answer->id, 'category'=>$query->category] )}}">{{$answer->answer_content}}</a>
                                <?php   }else{
                                        ?>                                
                                            <a href="{{route('admin_multiple.index', ['step' => 'multiple-choice', 'type'=>$type,'query_id'=>$mul_q_id, 'answer_id'=>$answer->id, 'category'=>$query->category] )}}">{{$answer->answer_content}}</a>
                                <?php   }
                                    }
                                ?>            
                            </td>
                            <td>{{str_replace('-','/',explode(' ', $answer->created_at)[0])}}</td>
                            <td>
                                <?php 
                                    $mul= DB::table('query')->where('Aid', $answer->id)->get();                                    
                                    if(count($mul) == 0){?>
                                        <a href="{{route('admin_multiple.index', ['step'=>'register', 'type'=>$type, 'query_id'=>$answer->Qid, 'answer_id'=>$answer->id, 'category'=>$query->category ] )}}" class="edit">編集</a>                                        
                                <?php 
                                    }else{ 
                                        
                                        ?>
                                        <a href="{{route('admin_multiple.index', ['step' => 'multiple-edition', 'type'=>$type,'query_id'=>$mul_q_id, 'answer_id'=>$answer_id, 'category'=>$category] )}}" class="edit">編集</a>
                                <?php 
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
                @if($return_mode == 1)
                    <a class="btn-action"  href="{{route('admin_add_new.index', ['step' => 'top-query-management', 'type'=>$type, 'transID'=>$return_query_id])}}">ひとつ前の質問に戻る</a>
                @elseif($return_mode == 2)
                    <a class="btn-action"  href="{{route('admin_multiple.index', ['step' => 'multiple-choice', 'type'=>$type, 'query_id'=>$return_query_id, 'answer_id'=>$return_answer_id, 'category'=>$category])}}">ひとつ前の質問に戻る</a>
                @endif
            </div>
        </div><!------------ end of multiple-choice  ------------->
        @endif
        @if($step == 'multiple-edition')
        <div class='multiple-edition'>
            <div class="card-header">TOP質問 &nbsp;&nbsp;&nbsp; 編集</div>
            <p class='title'>質問内容</p>
            <form action="" method="POST" id="edition-form">
                @csrf
                <div class="">
                    <input name="type" value="{{$type}}" hidden>
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            ID
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <span class="new-id-multiple">{{$result}}</span>
                            <span>答え ： {{$parent_answer}}</span>                            
                        </div>
                        <input type="text" name="query_id" value="{{$query->id}}" hidden>
                        <input type="text" name="answer_id" value="{{$answer_id}}" hidden>
                        <input type="text" name="category" value="{{$category}}" hidden>
                    </div>                    
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            質問内容
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <input class="query-content" type="text" name="query_content" value="{{$query->query_content}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2 answer-col-2">                               
                            <div class="row answer-name">答</div>                            
                        </div>
                        <div class="col-md-10 col-sm-10 answer-dynamic">
                            @if(!empty($child_answer))
                                <?php $i = 1;?>
                                @foreach($child_answer as $answer)
                                    <div class="row">
                                        <span class="id"><?php echo $i;?>. </span>
                                        <input type="text" data-id="{{$answer->id}}" name="query_answer[]" value="{{$answer->answer_content}}"> 
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
        @endif
        
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
            <input class="multiple" value="0" hidden>
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
        var multi = $("#dialog-warning .multiple").val();
        //console.log(query_id+"::"+type+"::"+table_id+"::"+return_mode);
        if(multi == 0){
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
        }else{
            $.ajax({
                url: "{{route('admin_multiple.delete')}}",
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
        }
        
    });
    $("#dialog-warning .del-cancel").click(function(){
        $("#dialog-warning").css("display", "none");        
    });
    // query-edition submit
    $(".multiple-edition .btn-section .run").click(function(event){
        event.preventDefault();

        var data = new Object();
        data.query_id = $("#edition-form input[name='query_id']").val();
        data.category = "{{$category}}";
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
        
            console.log(data);
            
            $.ajax({
                url: "{{route('admin_multiple.edition')}}",
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

    $(".multiple-section .multiple-choice .query-delete").click(function(event){
        var id = "{{$query_id}}";

        console.log(id);

        $("#dialog-warning").css("display", "block");        
        $("#dialog-warning .del-id").val(id);
        $("#dialog-warning .type").val("{{$type}}");
        $("#dialog-warning .table-id").val('2'); // query
        $("#dialog-warning .return-mode").val('dashboard');
        //$("#dialog-warning .multiple").val('1');
    });

    $(".multiple-choice .table-section .delete").click(function(event){        
        var id = $(event.target).closest("tr").find(".id").val();
        console.log(id);
        $("#dialog-warning").css("display", "block");        
        $("#dialog-warning .del-id").val(id);
        $("#dialog-warning .type").val("{{$type}}");
        $("#dialog-warning .table-id").val('1'); // answer
        $("#dialog-warning .return-mode").val('reload');        
    });
});
</script>

