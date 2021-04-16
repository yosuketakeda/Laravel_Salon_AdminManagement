@include('include/header-admin')

<div class="rate-section">
    <div class="container">
        <div class="card-header">質問返答割合</div>
        <div>
            <a class="link-top" href="{{route('admin_query_overall.index')}}">質問全体図に戻る</a>
        </div>
        <div class="title">{{$query->query_content}}</div>
        
        {!!$pie->html() !!}
        
    </div>
</div>

{!! Charts::scripts() !!}

{!! $pie->script() !!}

@include('include/footer')
