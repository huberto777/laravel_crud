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
                        auth="{{Auth::user() ?? false}}">
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

    <div id="addComment"
        auth="{{Auth::user() ?? false}}"
        isCommented="{{$article->isCommented()}}"
        name="Article"
        model="{{$article}}"
        count="{{$article->comments->count() ?? false }}"
        comments="{{$article->comments}}"
        placeholder="{{$placeholder}}"
    >
        @include('comments._form')
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
                    {auth ? isLiked ? <a onClick={this.handleUnlike}>odlub</a> : <a onClick={this.handleLike}>polub</a>
                     : <a href="{{ route('login') }}">zaloguj się aby ocenić artykuł</a>}
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

