@include('include/header-admin')

<div class="query-overall">
    <div class="container">
        <div class="card-header">TOP質問 &nbsp;&nbsp;&nbsp; 編集</div>
        @if(!empty($top_query) && !empty($top_answer) )
        <form action="{{route('admin_query_overall.index')}}" id="overall" method="GET">        
            <div>
                <a class="link-top" href="{{route('admin_dashboard.index')}}">TOPに戻る</a>
            </div>
            <div class="query-select">
                <span class="title">TOP質問内容選択</span>
                <select class="queries">
                    @if(count($queries)!=0)
                        <?php $i=0;?>
                        @foreach($queries as $query)
                            @if($i == $index)
                                <option value="{{$i."|".$query->id}}" selected>{{$query->query_content}}</option>
                            @else
                                <option value="{{$i."|".$query->id}}">{{$query->query_content}}</option>
                            @endif
                            <?php $i++;?>
                        @endforeach
                    @endif
                </select>
                <input id="top-queries" name="next_id" value="" hidden>
                <input id="index" name="index" value="" hidden>
            </div>
            <div class="overall">
                <div class="first">
                    <span class="query"> 
                        <span style="margin-right: 10px;">({{$top_query->Qnum}})</span>
                        <span>{{$top_query->query_content}}</span>
                    </span>
                    <div class="action-section">
                        <input class="q-id" value="{{$top_query->id}}" hidden>
                        <a class="edit" href="{{route('admin_add_new.index', ['step'=>'query-edition', 'type'=>$top_query->type, 'transID'=>$top_query->id])}}">編集</a>
                        <span class="del">削除</span>
                        <a class="rate" href="{{route('admin_rate.index', ['query_id'=>$top_query->id])}}">返答割合</a>
                    </div>                
                </div>
                <div class="answer-section">
                    <?php $i=0; 
                        $symbols=['①','②','③','④','⑤','⑥','⑦','⑧','⑨','⑩','⑪','⑫','⑬','⑭','⑮','⑯','⑰','⑱','⑲','⑳'];
                    ?>
                    @foreach($top_answer as $ans)
                        <div style="margin: 3px 0;">
                            <span class="symbol">{{$symbols[$i]}}</span>
                            <span>{{$ans->answer_content}}</span>
                        </div>
                        <?php $i++;?>
                    @endforeach
                </div>
                <div style="display: inline-flex; width: auto;">
                    <?php $i=0;?>                    
                    @foreach($top_answer as $answer)
                    <?php
                        $Aid = $answer->id;
                        $Q = DB::table('query')->where('Aid', $Aid )->get()->first();
                        
                        if(!empty($Q)){                              
                            $choice_id = $Q->choice_id;
                            if(!empty($choice_id)){
                                $Choice_Q = DB::table('query')->where('Aid', $Aid )->get(); 
                                $i = 1;
                                ?>
                                <div style="margin-right: 40px; width: 640px;">
                                @foreach($Choice_Q as $q)
                                    <div class="choice-value">
                                        <span style="margin-right: 10px;">(<?php
                                            $result = '';
                                            $Aid = $answer->id;
                                            /// when add new question for answer --- new question number
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
                                            $result .= '-'.$q->choice_id;
                                            echo $result;
                                            ?>)
                                        </span>
                                        <span class="query">{{$q->query_content}}</span>
                                        <div class="action-section">
                                            <input class="q-id" value="{{$q->id}}" hidden>                                            
                                            <a class="edit" href="{{route('admin_choice.index', ['step' => 'choice-management', 'type'=>$q->type,'query_id'=>$q->id, 'answer_id'=>$q->Aid, 'category'=>$q->category, 'last_template_selected'=>$q->last_template ])}}">編集</a>
                                            <span class="del">削除</span>
                                            <a class="rate" href="{{route('admin_rate.index', ['query_id'=>$q->id])}}">返答割合</a>
                                        </div>
                                    </div>
                                    <?php $i++;?>
                                    <?php $template = $q->last_template;?>
                                @endforeach
                                <?php 
                                $temp = DB::table('last_template')->where('id', $template)->get()->first();
                                
                                if(!empty($temp)){                                    
                                    ?>                                
                                    <div class="template">
                                        <span style="margin-right: 10px">(F-{{$temp->template_id}})</span>
                                        <span>{{$temp->template_name}}</span>
                                        <div class="action-section">
                                            <a class="edit" href="{{route('admin_last_template.index', ['step'=>'last-template-management', 'template_id'=>$temp->template_id, 'mode'=>'edition'])}}">編集</a>
                                            <span class="del">削除</span>
                                        </div>
                                    </div>
                                </div>                                
                                <?php
                                }
                            } else { ?>
                            <div style="margin-right: 40px; width: 640px;">
                                <div class="node">
                                    <span style="margin-right: 10px;">(<?php
                                        $result = '';
                                        $Aid = $answer->id;
                                        /// when add new question for answer --- new question number
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
                                        ?>)
                                    </span>
                                    <span>
                                        {{$Q->query_content}}
                                    </span>
                                    <div class="action-section">
                                        <input class="q-id" value="{{$Q->id}}" hidden>
                                        <a class="edit" href="{{route('admin_multiple.index', ['step' => 'multiple-edition', 'type'=>$Q->type,'query_id'=>$Q->id, 'answer_id'=>$Q->Aid, 'category'=>$Q->category] )}}">編集</a>
                                        <span class="del">削除</span>
                                        <a class="rate" href="{{route('admin_rate.index', ['query_id'=>$Q->id])}}">返答割合</a>
                                    </div>
                                </div><!---------- node yellow part----------->                                                
                                <?php
                                    $aid = $Q->id;
                                    $A = DB::table('answer')->where('Qid', $aid)->get();
                                    $j = 0;
                                ?>  
                                <div class="node-answer">                          
                                    @foreach($A as $ans)
                                        <div class="">
                                            <span class="symbol">{{$symbols[$j]}}</span><span>{{$ans->answer_content}}</span>
                                        </div>
                                        <?php $j++?>
                                    @endforeach
                                </div> 
                            <!------------------------------------- LOOP Childs ------------------------------------>
                                @foreach($A as $ans)
                                    <?php //// loop childs
                                    $child_q = DB::table('query')->where('Aid', $ans->id)->get()->first(); 
                                    ?>
                                    <div>
                                        @include('admin-overall-recursive')
                                    </div>                                                                
                                    <!----- end of loop childs------>
                                @endforeach
                            <!--------------------------------END of LOOP Child -------------------------------->                            
                                <?php $i++;?>
                            </div>                        
                        <?php
                            }  // if ---------- when answer has last template question
                        } /// if ----- when answer has quesiton
                    ?>                
                    @endforeach
                </div>            
            </div><!--------------overall ---------------->            
            </form>
        @endif
    </div><!--------------- container ------------------->    
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
        //console.log(query_id+"::"+type+"::"+table_id+"::"+return_mode);
        $.ajax({
            url: "{{route('admin_overall.delete')}}",
            type: "POST",
            data: {"query_id":query_id },
            success: function (data) {        
                if(data.success){
                    console.log("Successed!"); 
                    console.log(data.value);
                    location.reload();
                }else{
                    console.log("Failed!");                    
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

    $(".action-section .del").click(function(event){
        $("#dialog-warning").css("display", "block");  
        var query_id = $(event.target).closest('div').find('.q-id').val();
        $("#dialog-warning .del-id").val(query_id);
         console.log("in - "+query_id);
    });

/////////////////////////////////////////////////////////////////////////
    $('.query-overall .queries').on('change', function() {
        var query = this.value;
        console.log("input::" + query);
        var ids = query.split("|");

        $("#index").val(ids[0]);
        $("#top-queries").val(ids[1]);

        $("#overall").submit();

    });
});
</script>