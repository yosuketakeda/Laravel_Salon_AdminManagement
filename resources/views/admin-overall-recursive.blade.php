<?php
$escape = false;  /// recursive serious escape.

while(1){
    if($child_q == null) break;     
    $child_choice_id = $child_q->choice_id;
    if(!empty($child_choice_id)){
        $child_Choice_Q = DB::table('query')->where('Aid', $ans->id )->get(); 
        ?>
        <div>
        @foreach($child_Choice_Q as $q)
            <div class="choice-value">
                <span style="margin-right: 10px;">(<?php
                    $result = '';
                    $Aid = $ans->id;
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
            break;
        }else{
            break;
        }
    } else { 
        if($escape == false){
        ?>    
        <div class="node">
            <span style="margin-right: 10px;">(<?php
                $result = '';
                $Aid = $ans->id;
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
                {{$child_q->query_content}}    
            </span>
            <div class="action-section">
                <input class="q-id" value="{{$child_q->id}}" hidden>
                <a class="edit" href="{{route('admin_multiple.index', ['step' => 'multiple-edition', 'type'=>$child_q->type,'query_id'=>$child_q->id, 'answer_id'=>$child_q->Aid, 'category'=>$child_q->category] )}}">編集</a>
                <span class="del">削除</span>
                <a class="rate" href="{{route('admin_rate.index', ['query_id'=>$child_q->id])}}">返答割合</a>
            </div>
        </div><!---------- node yellow part----------->
        <?php
        }  /// escape of each for
            $child_answers = DB::table('answer')->where('Qid', $child_q->id)->get();
            $k = 0;?>    
            <div class="node-answer"> 
                <?php
                if($escape == false){
                    foreach($child_answers as $child_a){ ?> 
                        <div><span class="symbol">{{$symbols[$k]}}</span><span>{{$child_a->answer_content}}</span></div>
                        <?php
                        $k++;
                    } 
                }
                foreach($child_answers as $child_a){ ?>
                    <?php
                        $child_q = DB::table('query')->where('Aid', $child_a->id)->get()->first();    
                    ?>                
                    <div>
                        @include('admin-overall-recursive', ['ans'=>$child_a])
                    </div>
                <?php }
                $escape = true; 
                ?>            
            </div>
        <?php
        
    } /// if 2 Selection   
}
?>