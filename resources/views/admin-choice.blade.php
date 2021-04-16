@include('include/header-admin')

<div class="admin-choice">
    <div class="container">
        <div class="register"> <!--- new register --->
            <form action="{{route('admin_choice.register')}}" method="POST">
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
                    <input type="text" name="parent_answer" value="{{$parent_answer}}" hidden>
                </div>
                <div class="query-section">
                    @if(count($queries)==0)                
                        <div class="row">
                            <div class="col-md-2 col-sm-2 next">
                                <div class=".row answer-name">質問内容</div>
                            </div>
                            <div class="col-md-10 col-sm-10">
                                <span>A</span><input name="alternative_num[]" value="0" hidden>
                                <textarea type="text" rows="1" name="query_content[]" value="" required></textarea>
                            </div>
                        </div>     
                    @else
                        <?php $i=0;?>
                        @foreach($queries as $query)
                            <div class="row">
                                <div class="col-md-2 col-sm-2 next">
                                    <div class=".row answer-name">質問内容</div>
                                </div>
                                <div class="col-md-10 col-sm-10">
                                <?php 
                                    $param = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
                                ?>
                                <span>{{$param[$i]}}</span>
                                <textarea type="text" rows="1" name="query_content[]" value="" required>{{$query->query_content}}</textarea>
                                </div>
                            </div>     
                            <?php $i++;?>
                        @endforeach                
                    @endif
                </div>
                <div class="btn-section up">
                    <div style="display: flex">
                        <span class="add">次の２択の質問を追加</span>
                        <button class="link-choice">質問を追加しないで登録</button>
                    </div>
                </div>                
            </form>
        </div><!--------- end of new register ---------->
        <div class="choice-edition"> 
            <form action="{{route('admin_choice.edition')}}" method="POST">
                @csrf
                <div class="card-header">質問 編集</div>                       
                <input name="type" value="{{$type}}" hidden>
                <input name="category" value="{{$category}}" hidden>
                <div class="row">
                    <div class="col-md-5 col-sm-5">
                        質問内容
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
                    <input name="query_id" value="{{$query_id}}" hidden>
                    <input name="answer_id" value="{{$answer_id}}" hidden>
                    <input name="parent_answer" value="{{$parent_answer}}" hidden>
                </div>
                <div class="table-section">
                    <table>
                        <th>ID</th>
                        <th>質問内容</th>                    
                        @if(!empty($queries))                             
                            @foreach($queries as $query)
                            <tr>
                                <td class="id">{{$result."-".$query->choice_id}}</td>
                                <td>{{$query->query_content}}</td>                                
                            </tr>
                            <?php
                                $last_template_selected = $query->last_template;
                            ?>
                            @endforeach
                        @endif                        
                    </table>
                </div>
                <div class="btn-section">
                    <div style="margin:auto; display: flex;">
                        <a class="return-input" href="{{route('admin_choice.index', ['step'=>'choice-management', 'type'=>$type, 'query_id'=>$query_id, 'answer_id'=>$answer_id, 'category'=>$category, 'last_template_selected'=>$last_template_selected])}}">編集</a>
                        <span class="add-last-template">登録</span>
                    </div>
                </div>
                <div class="last-template">
                    <div class="title">最後の質問テンプレートの選択</div>
                    <div style="margin-bottom: 20px">
                        @if(!empty($last_template))
                        <select class="query-cat">
                            <?php $i=1;?>
                            @foreach($last_template as $template)
                                <option value="{{$template->id}}">{{$template->template_name}}</option>
                                <?php $i++;?>
                            @endforeach
                        </select>
                        @endif
                    </div>
                    <input type="text" class="last-template-selected" name="last_template_selected" value="{{$last_template[0]->id}}" hidden>
                    <button type="submit" class="run">登録</button>
                </div>
            </form>
        </div><!------------ end of choice edition  ------------->
        <div class="choice-management"> 
            <form action="{{route('admin_choice.edition')}}" method="POST">
                @csrf
                <div class="card-header">質問 管理</div>                       
                <input name="type" value="{{$type}}" hidden>
                <input name="category" value="{{$category}}" hidden>
                <div class="row">
                    <div class="col-md-5 col-sm-5">
                        質問内容
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
                    <input name="query_id" value="{{$query_id}}" hidden>
                    <input name="answer_id" value="{{$answer_id}}" hidden>
                    <input name="parent_answer" value="{{$parent_answer}}" hidden>
                </div>          
                <div class="table-section">
                    <table>
                        <th>ID</th>
                        <th>質問内容</th>                    
                        @if(!empty($queries))                             
                            @foreach($queries as $query)
                            <tr>
                                <td class="id">{{$result."-".$query->choice_id}}<input class="choice-id" value="{{$query->id}}" hidden></td>
                                <td style="text-align: left; padding-left: 30px; padding-right: 30px">
                                    {{$query->query_content}}                                    
                                    <a href="javascript:void(0);" class="delete" style="float:right">削除</a>
                                    <a href="{{route('admin_choice.index',['step'=>'register', 'type'=>$query->type, 'query_id'=>$query->id, 'answer_id'=>$query->Aid, 'category'=>$query->category, 'parent_answer'=>$parent_answer])}}" class="edit" style="float:right; margin-right: 5px">編集</a>
                                </td>                            
                            </tr>
                            @endforeach
                        @endif                        
                    </table>
                </div>                
                <div class="last-template-manage">
                    <div class="title">最後の質問テンプレートの選択</div>
                    <div class="btn-one">
                        <div style="margin-bottom: 20px">
                            <input value="<?php
                                if(!empty($last_template)){
                                    foreach($last_template as $template){
                                        if($template->id == $last_template_selected)
                                            echo $template->template_name;
                                    }
                                }
                            ?>" disabled>
                        </div>                    
                        <span class="run">編集</span>
                    </div>
                    <div class="btn-two">
                        <div style="margin-bottom: 20px">
                            @if(!empty($last_template))
                            <select class="query-cat">
                                <?php $i=0;?>
                                @foreach($last_template as $template)
                                    <option value="{{$template->id}}">{{$template->template_name}}</option>
                                    <?php $i++;?>
                                @endforeach
                            </select>
                            @endif
                        </div>
                        <input type="text" class="last-template-selected" name="last_template_selected" value="{{$last_template[0]->id}}" hidden>
                        <button type="submit" class="run">登録</button>
                    </div>
                </div>
            </form>
        </div><!------------ end of choice management  ------------->
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
        //console.log(query_id+"::"+type+"::"+table_id+"::"+return_mode);
        var query_id = $("#dialog-warning .del-id").val();
    
        $.ajax({
            url: "{{route('admin_choice.delete')}}",
            type: "POST",
            data: {"query_id":query_id },
            success: function (data) {
                if(data.success){
                    console.log("Successed!"); 
                    console.log(data.id);
                    location.reload();
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

    $(".admin-choice .choice-management .delete").click(function(event){
        var query_id = $(event.target).closest("tr").find(".choice-id").val();
        $("#dialog-warning .del-id").val(query_id);
        $("#dialog-warning").css("display", "block");        
    });
});
</script>