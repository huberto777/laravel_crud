@extends('layouts.app')
@section('title', $video->title)

@section('content')
	<div class="col-md-12">
        <div class="jumbotron bg-dark text-white">
            <h2>{{ $video->title }}</h2>
            <div class="embed-responsive embed-responsive-16by9 mb-2">
                <iframe class="embed-responsive-item" src="{{ $video->url }}?showinfo=0" frameborder="0" allowfullscreen></iframe>
            </div>
            <h5>{{ $video->description }}</h5>
            <hr class="border-warning">
            <div class="row">
                <div class="col-md-3">
                    <h5>autor: <div class="badge badge-pill badge-warning mb-2">{{ $video->user->name }}</div>
                    </h5>
                </div>
                <div class="col-md-3">
                    <h5>dodano: <div class="badge badge-pill badge-info">{{ $video->created_at }}</div></h5>

                </div>
                <div class="col-md-3">
                    <div id="like"
                        video="{{$video}}"
                        auth="{{Auth::user() ?? false}}"
                        count="{{$video->users->count()}}"
                        isLiked="{{$video->isLiked()}}"
                    >
                    </div>
                </div>
                <div class="col-md-3">
                    <h5>tagi:
                    @foreach($video->tags as $tag)
                        <h5>
                        <div class="badge badge-pill badge-danger"><a href="{{ route('videoTags',[$video->id,$tag->id]) }}" class="text-white"></a>{{ $tag->name }}</div>
                        </h5>
                    @endforeach
                    </h5>
                </div>
            </div>
            <hr class="border-warning">
            <a href="{{ route('videos.index') }}" class="btn btn-block btn-outline-warning">powrót do listy video</a>
            <hr class="border-warning">
            <h5 class="mt-2">ARCHIWUM:</h5>
                @foreach($archives as $archive)
                    <a href="{{ route('archiveVideos',['year'=>$archive->year,'month'=>$archive->month]) }}" class="badge badge-warning">{{ $archive->year.' '.$archive->month }}</a>
                @endforeach
        </div>
    </div>
    <div class="col-md-12">
        @include('session')
        @include('error')
    </div>

    <div id="addComment"
        auth="{{Auth::user() ?? false }}"
        isCommented="{{$video->isCommented()}}"
        name="Video"
        model="{{$video}}"
        count="{{$video->comments->count() ?? false }}"
        comments="{{$video->comments}}"
        placeholder="{{$placeholder}}"
    >
        @include('comments._form')
    </div>
{{-- SELECT auto_increment FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'NazwaTabeli'; --}}
@endsection

@section('scripts')
    <script type="text/babel">
        class Like extends React.Component {
            constructor(props) {
                super(props);
                this.state = {
                    video: JSON.parse(props.video),
                    auth: props.auth,
                    count: JSON.parse(props.count),
                    isLiked: props.isLiked
                }
                // console.log(props);
            }
            likeVideo = (e) => {
                e.preventDefault();
                this.setState({
                    count: this.state.count + 1,
                    isLiked: !this.state.isLiked,
                })
                axios.get(`/like/${this.state.video.id}/Video`)
                    .then(response => response.data)
                    .catch(error => console.log(error));
            }
            unlikeVideo = (e) => {
                e.preventDefault();
                this.setState({
                    count: this.state.count - 1,
                    isLiked: !this.state.isLiked
                })
                // console.log(this.state.isLiked);
                axios.get(`/unlike/${this.state.video.id}/Video`)
                    .then(res => res.data)
                    .catch(err => console.log(err));
            }
            render() {
                const { video, auth, count, isLiked } = this.state;
                return (
                    <>
                        <h4><i className="far fa-thumbs-up fa-lg"></i> <div className="badge badge-pill badge-info">{count}</div></h4>
                        {
                            auth ? isLiked ? <a onClick={this.unlikeVideo}>odlub</a> : <a onClick={this.likeVideo}>polub</a> : <a href="{{ route('login') }}">zaloguj się aby polubić video</a>
                        }
                    </>
                )
            }
        }
        let auth = document.getElementById('like').getAttribute('auth');
        let admin = document.getElementById('like').getAttribute('admin');
        let video = document.getElementById('like').getAttribute('video');
        let count = document.getElementById('like').getAttribute('count');
        let isLiked = document.getElementById('like').getAttribute('isLiked');
        ReactDOM.render(<Like auth={auth} admin={admin} video={video} count={count} isLiked={isLiked} />, document.getElementById('like'))
    </script>
@endsection
