@include('include/header-common')

<div class="home">
    <div class="container">        
        <div class="question-section">
            @if(!empty($queries))
                @foreach($queries as $query)
                <div class="question">
                    <span class="symbol">Question</span>
                    <a href="{{route('common.index', ['step'=>'first-step', 'type'=>$query->type, 'query_id'=>$query->id, 'category'=>$query->category])}}">
                        {{$query->query_content}}
                    </a>
                </div>                    
                @endforeach
            @endif
        </div>        
    </div>
</div>

@include('include/footer')
