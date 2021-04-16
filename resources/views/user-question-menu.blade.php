@include('include/header-user')

<div class="question-menu">
    <div class="container">
        <div class="card-header">質問メニュー</div>
        <div class="question-section">
            @if(!empty($queries))
                @foreach($queries as $query)
                <div class="question">
                    <a href="{{route('user_answer.index', ['step'=>'first-step', 'type'=>$query->type, 'query_id'=>$query->id, 'category'=>$query->category, 'query_content'=>$query->query_content])}}">
                        {{$query->query_content}}
                    </a>
                </div>                   
                @endforeach
            @endif
        </div>        
    </div>
</div>

@include('include/footer')

