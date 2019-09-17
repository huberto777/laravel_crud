@extends('layouts.app')
@section('title'){{ $article->title }}
@endsection

@section('content')
    <div class="col-md-12">
        <div class="jumbotron bg-dark text-white" style="min-height: 400px">
            <h3>{{ $article->title }}</h3>
            <hr class="border-warning">
            <div class="card bg-dark">
                <h5>
                    <img src="{{ $article->path == null ? $placeholder : asset("storage/{$article->path}")  }}" width="250" height="200" alt="" align="left" class="mr-4 img-fluid">{{ $article->description }}
                </h5>
            </div>
            <hr class="border-warning">
            <div class="row">
                <div class="col-md-3">
                    <h5>autor: <div class="badge badge-pill badge-warning mb-2">{{ $article->user->name }}</div></h5>

                    </h5>
                    <h5>tagi:<br/>
                    @foreach($article->tags as $tag)
                        <div class="badge badge-pill badge-danger"><a href="{{ route('articleTags',[$article->slug,$tag->id]) }}" class="text-white">{{ $tag->name ?? 0 }}</a></div><br>
                    @endforeach
                    </h5>
                </div>
                <div class="col-md-3">
                    <h5>dodano: <div class="badge badge-pill badge-info">{{ $article->created_at }}</div></h5>
                </div>
                <div class="col-md-3">
                    <h5>kategoria: <div class="badge badge-pill badge-danger">{{ $article->category->name }}</div>
                </div>
                <div class="col-md-3">
                    <div id="like"
                        count="{{$article->users->count()}}"
                        article="{{$article}}"
                        isLiked="{{$article->isLiked()}}"
                        auth="{{Auth::user() ?? null}}">
                    </div>
                </div>
            </div>
            <hr class="border-warning">
            <a href="{{ route('articles.index') }}" class="btn btn-block btn-outline-warning">powrót do listy artykułów</a>
            <hr class="border-warning">
            <h5 class="mt-2">ARCHIWUM:</h5>
            @foreach($archives as $archive)
                <a href="{{ route('archiveArticles',$archive->year) }}" class="badge badge-warning">{{ $archive->year }}</a>
            @endforeach
        </div>
    </div>

    @include('session')
    @include('error')
    @include('comments._form',[
        'article' => $article
    ])

    <div class="col-md-12">
        <div class="jumbotron bg-dark text-white">
            <h2>Komentarze <div class="badge badge-pill badge-warning">{{ $article->comments->count() ?? false }}</div></h2>
            <hr class="bg-warning">
            @foreach($article->comments as $comment)
                <img src="{{ $comment->user->path == null ? $placeholder : asset("storage/{$comment->user->path}") }}" alt="" height="30" width="25" align="left">
                <h4>autor: {{ $comment->user->name }}</h4>
                <hr>
                <h5>{{ $comment->content }}</h5>
                <h5>{!! $comment->rating !!}</h5>
                @if(Auth::user() && Auth::user()->hasRole(['admin']))
                    <a href="{{ route('editComment',$comment->id) }}" class="btn btn-outline-primary"><i class="far fa-edit"></i></a>
                    <a href="{{ route('deleteComment',$comment->id) }}" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i></a>
                @endif
                <hr class="bg-warning">
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/babel">
    class Like extends React.Component{
        constructor(props){
            super(props);
            this.state = {
                isLiked: props.isLiked,
                auth: props.auth,
                article: JSON.parse(props.article),
                count: JSON.parse(props.count),
            }
            // console.log(props);
        }
        handleLike = e => {
            e.preventDefault();
            this.setState({
                isLiked: !this.state.isLiked,
                count: this.state.count + 1
            })
            // console.log(this.state.isLiked);
            axios.get(`/like/${this.state.article.id}/Article`).then(response=>response.data).
            catch(error=>console.log(error));

        }
        handleUnlike = e => {
            e.preventDefault();
            this.setState({
                isLiked: !this.state.isLiked,
                count: this.state.count - 1
            })
            // console.log(this.state.isLiked);
            axios.get(`/unlike/${this.state.article.id}/Article`).then(response=>response.data).
            catch(error=>console.log(error));
        }
        render(){
            const {auth,isLiked,count} = this.state;
            return (
                <>
                    <h4>
                        <i className="fas fa-thumbs-up fa-lg"></i> <div className="badge badge-pill badge-danger">{count}</div>
                    </h4>
                    {auth ? isLiked ? <a onClick={this.handleLike}>polub</a> :
                    <a onClick={this.handleUnlike}>odlub</a> : <a href="{{ route('login') }}">zaloguj się aby ocenić artykuł</a>}
                </>
            )
        }
    }
    let article = document.getElementById("like").getAttribute("article");
    let isLiked = document.getElementById("like").getAttribute("isLiked");
    let auth = document.getElementById("like").getAttribute("auth");
    let count = document.getElementById("like").getAttribute("count");

    ReactDOM.render(<Like count={count} article={article} isLiked={isLiked} auth={auth}  />,document.getElementById('like'));
</script>
@endsection

