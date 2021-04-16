@include('include/header-user')

<div class="common">
    <div class="container">
        @if($step === 'first-step')
        <div class="first">
            <div class="question-section">
                @if(!empty($query))
                    <div class="question">
                        <span class="symbol">Question</span>                    
                        {{$query->query_content}}                    
                    </div>                    
                @endif
            </div>   
            <div class="answer-section">
                <div style="margin-bottom: 15px">
                    <span class="symbol">answer</span>
                </div>
                @if(count($answers) !=0 )
                    <?php $i=1;?>
                    @foreach($answers as $answer)    
                    <div class="answer">
                        <?php
                            $multi = DB::table('query')->where('Aid', $answer->id)->get(); 
                            if(count($multi) == 0) {
                        ?>
                                <a href="">
                                    <span class="num">{{$i}}</span>
                                    <span>{{$answer->answer_content}}</span>
                                    <img class="arrow" src={{asset('public/assets/images/arrow.png')}}>
                                </a>
                        <?php    
                            }else{                                
                                $sub_query = DB::table('query')->where('Aid', $answer->id)->where('type', $type)->get()->first();
                                if($sub_query->choice_id == null){  //// multiple answers
                        ?>
                                    <a href="{{route('user_answer.index', ['step'=>'first-step', 'type'=>$query->type, 'query_id'=>$sub_query->id, 'answer_id'=>$answer->id, 'category'=>$query->category])}}">
                                        <span class="num">{{$i}}</span>
                                        <span>{{$answer->answer_content}}</span>
                                        <img class="arrow" src={{asset('public/assets/images/arrow.png')}}>
                                    </a>    
                        <?php        
                                }else{  //// A, B questions                                       
                        ?>
                                    <a href="{{route('user_answer.index', ['step'=>'choose', 'type'=>$query->type, 'query_id'=>$sub_query->id, 'query_content'=>$sub_query->query_content, 'index'=>0])}}">
                                        <span class="num">{{$i}}</span>
                                        <span>{{$answer->answer_content}}</span>
                                        <img class="arrow" src={{asset('public/assets/images/arrow.png')}}>
                                    </a>    
                        <?php 
                                }
                            }
                        ?>
                        
                    </div>
                    <?php $i++;?>
                    @endforeach               
                @endif

            </div>
            <div class="bottom">
                @if(!empty($query))
               <!-- <span class="symbol"> x -x -x </span> -->
                @endif
            </div> 
        </div>
        @endif
        @if($step === 'choose')
        <div class="choose">
            <div class="question">
                <span class="symbol">Question</span>                    
                @if(!empty($query_content))
                    {{$query_content}}                    
                @endif
            </div>
            <div class="answer-section">
                <div style="margin-bottom: 15px">
                    <span class="symbol">answer</span>
                </div>
                <div class="answer">
                    <a class="submit" href="javascript:void(0)">
                        <span class="num">1</span>
                        <span>YES</span>
                        <img class="arrow" src={{asset('public/assets/images/arrow.png')}}>                            
                    </a>     
                </div>
                <div class="answer">
                    <a class="back-home" href="javascript:void(0)">
                        <span class="num">2</span>
                        <span>NO</span>
                        <img class="arrow" src={{asset('public/assets/images/arrow.png')}}>
                    </a>     
                </div>
            </div>
            <div class="bottom">                
               <!-- <span class="symbol"> x -x -x </span> -->
            </div> 
        </div>
        @endif
        @if($step === 'last-step')
        <div class="last-step">
            <div class="question-section">
                <div class="question">
                    <span class="symbol">Question</span>                    
                    @if(!empty($template_query))
                        {{$template_query}}       
                        <input class="final-template-id" value="{{$template_id}}" hidden>             
                    @endif
                </div>
            </div>
            <div class="answer-section">
                <div style="margin-bottom: 15px">
                    <span class="symbol">answer</span>
                </div>
                <div class="answer">
                    <a class="final_yes" href="javascript:void(0)">
                        <span class="num">1</span>
                        <span>YES</span>
                        <img class="arrow" src={{asset('public/assets/images/arrow.png')}}>                            
                    </a>     
                </div>
                <div class="answer">
                    <a class="final_no" href="javascript:void(0)">
                        <span class="num">2</span>
                        <span>NO</span>
                        <img class="arrow" src={{asset('public/assets/images/arrow.png')}}>
                    </a>     
                </div>
            </div>
            <div class="bottom">                
               <!-- <span class="symbol"> x -x -x </span> -->
            </div> 
        </div>
        @endif
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

    $(".answer .submit").click(function(){
        var type="{{$type}}";
        var query_id="{{$query_id}}";        
        var index = "{{$index}}";
        
        $.ajax({
            url: "{{route('common.answers')}}",
            type: "POST",
            data: {"query_id":query_id, "type": type, "index": index, "mode":'yes'},
            success: function (data) {                       
                if(data.success){
                    var url="";                    
                    if(data.final_template){  
                        url = '{{route("user_answer.index", ["step"=>"last-step", "template_id"=>":template_id", "template_query"=>":template_query" ])}}';
                        url = decodeURIComponent(url);
                        url = url.replace(':template_id', data.last_id);
                        url = url.replace(':template_query', data.last_query);
                        url = url.replace(/amp;/g, '');  

                        window.location.href = url;
                    }else{
                        url = '{{route("user_answer.index", ["step"=>"choose", "index"=>":index", "type"=>":type", "query_id"=>":query_id", "query_content"=>":query_content" ])}}';
                        url = decodeURIComponent(url);
                        url = url.replace(':index', data.index);  
                        url = url.replace(':type', data.type);
                        url = url.replace(':query_id', data.query_id);
                        url = url.replace(':query_content', data.query_content);
                        
                        url = url.replace(/amp;/g, '');
                        
                        window.location.href = url;
                    }                    
                }else{
                    console.log("Failed!");                    
                }
            },
            error: function(data) {
                console.log("Errors!!");
            }
        });

    });
    
    $(".answer .back-home").click(function(){
        var type="{{$type}}";
        var query_id="{{$query_id}}";        
        var index = "{{$index}}";
        $.ajax({
            url: "{{route('common.answers')}}",
            type: "POST",
            data: {"query_id":query_id, "type": type, "index": index, "mode": 'no'},
            success: function (data) {                       
                if(data.success){
                    var url="";                    
                    if(data.final_template){  
                        url = '{{route("user_answer.index", ["step"=>"last-step", "template_id"=>":template_id", "template_query"=>":template_query" ])}}';
                        url = decodeURIComponent(url);
                        url = url.replace(':template_id', data.last_id);
                        url = url.replace(':template_query', data.last_query);
                        url = url.replace(/amp;/g, '');  

                        window.location.href = url;
                    }else{
                        url = '{{route("user_answer.index", ["step"=>"choose", "index"=>":index", "type"=>":type", "query_id"=>":query_id", "query_content"=>":query_content" ])}}';
                        url = decodeURIComponent(url);
                        url = url.replace(':index', data.index);  
                        url = url.replace(':type', data.type);
                        url = url.replace(':query_id', data.query_id);
                        url = url.replace(':query_content', data.query_content);
                        
                        url = url.replace(/amp;/g, '');
                        
                        window.location.href = url;
                    }                    
                }else{
                    console.log("Failed!");                    
                }
            },
            error: function(data) {
                console.log("Errors!!");
            }
        });
    });  


    $(".answer .final_yes").click(function(){
        var final_id = $('.final-template-id').val();
        $.ajax({
            url: "{{route('common.final')}}",
            type: "POST",
            data: {"final_id": final_id, "mode":'yes'},
            success: function (data) {                       
                if(data.success){
                    var last_id = data.last_id;
                    var last_file = data.last_file;
                    var last_url = data.last_url;
                    
                    if(last_file != null){
                        if(last_file.indexOf('.jpg') > 0 || last_file.indexOf('.png') > 0 || last_file.indexOf('.jpeg') > 0 || last_file.indexOf('.JPG') > 0 || last_file.indexOf('.PNG') > 0 || last_file.indexOf('.JPEG') > 0){
                            url = '{{route("last_template_view.index", ["id"=>":id", "file"=>":file"])}}';
                            url = decodeURIComponent(url);
                            url = url.replace(':id', last_id);  
                            url = url.replace(':file', last_file);
                            url = url.replace(/amp;/g, '');
                            window.location.href = url;    
                        }else{
                            url = '{{url("public/uploads/last_template/:id/:file")}}';
                            url = decodeURIComponent(url);
                            url = url.replace(':id', last_id);  
                            url = url.replace(':file', last_file);
                            url = url.replace(/amp;/g, '');
                            window.location.href = url;
                            redirectPauseSeconds = 3;
                            
                            setTimeout("window.location.href = '{{route('user_question.index',['step'=>'question-section'])}}'",parseInt(redirectPauseSeconds*1000));
                        }
                    }
                    if(last_url != null){
                        window.location.href = last_url;
                    }
                    
                }else{
                    console.log("Failed!");                    
                }
            },
            error: function(data) {
                console.log("Errors!!");
            }
        });
    });

    $(".answer .final_no").click(function(){
        var final_id = $('.final-template-id').val();
        $.ajax({
            url: "{{route('common.final')}}",
            type: "POST",
            data: {"final_id": final_id, "mode":'no'},
            success: function (data) {                       
                if(data.success){
                    var last_id = data.last_id;
                    var last_file = data.last_file;
                    var last_url = data.last_url;
                    
                    if(last_file != null){
                        if(last_file.indexOf('.jpg') > 0 || last_file.indexOf('.png') > 0 || last_file.indexOf('.jpeg') > 0 || last_file.indexOf('.JPG') > 0 || last_file.indexOf('.PNG') > 0 || last_file.indexOf('.JPEG') > 0){
                            url = '{{route("last_template_view.index", ["id"=>":id", "file"=>":file"])}}';
                            url = decodeURIComponent(url);
                            url = url.replace(':id', last_id);  
                            url = url.replace(':file', last_file);
                            url = url.replace(/amp;/g, '');
                            window.location.href = url;    
                        }else{
                            url = '{{url("public/uploads/last_template/:id/:file")}}';
                            url = decodeURIComponent(url);
                            url = url.replace(':id', last_id);  
                            url = url.replace(':file', last_file);
                            url = url.replace(/amp;/g, '');
                            window.location.href = url;
                            redirectPauseSeconds = 3;
                            
                            setTimeout("window.location.href = '{{route('user_question.index',['step'=>'question-section'])}}'",parseInt(redirectPauseSeconds*1000));
                        }
                    }
                    if(last_url != null){
                        window.location.href = last_url;
                    }
                    
                }else{
                    console.log("Failed!");                    
                }
            },
            error: function(data) {
                console.log("Errors!!");
            }
        });
    });
    
});
</script>