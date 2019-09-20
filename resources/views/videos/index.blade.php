@extends('layouts.app')
@section('title')
	@if($year ?? false)
		{{ $month.'-'.$year }}
	@else
		lista video
	@endif
@endsection

@section('content')
    <div id="videos"
        auth="{{Auth::user() && Auth::user()->hasRole(['admin'])}}"
        videos="{{$videos}}"
        count="{{$videos->count()}}"
        month="{{$month ?? false}}"
        year="{{$year ?? false}}"
    >
    </div>
@endsection

@section('scripts')
    <script type="text/babel">
        const VideoItem = props => {
            const { id, title, url } = props.video;
            // console.log(props.video);
            return (
                <>
                    <div className="col-md-3">
                        <div className="card text-white bg-dark mb-2 px-2">
                            <div className="card-text">
                                    <h5><a href={`/videos/${id}`} className="ml-2 text-white text-decoration-none">{title.substr(0,10) + "..."}</a></h5>
					        </div>
					        <div className="embed-responsive embed-responsive-16by9 mb-2">
						        <iframe className="embed-responsive-item" src={url} frameBorder="0" allowFullScreen></iframe>
					        </div>
                            {auth ?
    						    <>
                                    <a href={`/videos/${id}/edit`}className="btn btn-sm btn-outline-primary"><i className="far fa-edit"></i></a>
                                    <button type="submit" className="btn btn-sm btn-outline-danger" onClick={() => props.delete(id)}><i className="far fa-trash-alt"></i></button>
                                </>
                                : ''
                            }
                        </div>
                    </div>
                </>
            )
        }
        class VideoList extends React.Component {
            constructor(props){
                super(props);
                this.state = {
                    videos: JSON.parse(props.videos),
                    count: props.count,
                    search: ''
                }
                // console.log(JSON.parse(props.videos));
            }
            deleteVideo = id => {
                // console.log(id);
                if(this.props.auth) {
                    let videos = [...this.state.videos];
                    let index = videos.findIndex(video => video.id === id);
                    videos.splice(index,1);
                    this.setState({
                        videos,
                        count: this.state.count - 1
                    })
                    axios.delete(`videos/${id}`)
                        .then(response => response.data)
                        .catch(error => console.log(error));
                } else {
                    alert('zaloguj się');
                }
            }
            handleSearch = e => {
                this.setState({
                    search: e.target.value.toLowerCase()
                })
            }
            render() {
                const { year, month, auth } = this.props;
                const { count, search } = this.state;
                const videos = this.state.videos.filter(video => video.title.toLowerCase().includes(search));
                return (
                    <>
                        <div className="jumbotron bg-dark text-white">
                            <div className="row">
                                <div className="col-md-8">
                                    { year ?
                                        <h2>Archiwum: {month - year}</h2>
                                    :
                                        <>
                                            <h2>Lista video</h2>
                                            <h5>ilość: {count}</h5>
                                        </>
                                    }
                                </div>
                                <div className="col-md-4">
                                    <input type="text" className="form-control" placeholder="Video" onInput={this.handleSearch} />
                                </div>
                            </div>
                        </div>

                        {auth ? <a href="{{ route('videos.create') }}" className="btn btn-block btn-success mb-2">dodaj video</a> : '' }

                        <div className="row">
                            {videos.map(video => (
                                <VideoItem key={video.id} auth={auth} video={video} delete={this.deleteVideo} />
                            ))}
                        </div>
                    </>
                )
            }
        }
        let auth = document.getElementById('videos').getAttribute('auth');
        let videos = document.getElementById('videos').getAttribute('videos');
        let count = document.getElementById('videos').getAttribute('count');
        let month = document.getElementById('videos').getAttribute('month');
        let year = document.getElementById('videos').getAttribute('year');
        ReactDOM.render(<VideoList auth={auth} videos={videos} count={count} month={month} year={year} />, document.getElementById('videos'));
    </script>
@endsection
