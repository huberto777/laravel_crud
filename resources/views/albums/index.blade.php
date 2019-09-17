@extends('layouts.app')
@section('title','albumy')

@section('content')
    <div id="albums"
        auth="{{Auth::user() && Auth::user()->hasRole(['admin'])}}"
        placeholder="{{$placeholder}}"
        albums="{{$albums}}"
        count="{{$albums->count()}}"
    >
    </div>


        {{-- @foreach($albums->chunk(4) as $chunked_album)
        <div class="row"> --}}

@endsection

@section('scripts')
    <script type="text/babel">
        const AlbumItem = props => {
            const { id, name, photos, storage_path } = props.album;
            // console.log(props.album);
            console.log(photos);
            // console.log(`${storage_path}/${photos[0][0].path}`);
            return (
                <>
                    <div className="col-md-3 mb-2">
                        <a href={`albums/${id}`} className="photo text-decoration-none">
                            <div className="card-img  pb-2 bg-dark"><img src={`${photos.length}` !== null ? `${storage_path}/${photos}` : props.placeholder} title={`${name}`} className="img-thumbnail bg-dark" />
                                <span className="text-white ml-2">{name}</span>
                            </div>
                        </a>
                        {props.auth ?
                            <><a href={`albums/${id}/edit`} className="btn btn-sm btn-outline-primary"><i className="far fa-edit"></i></a>
                            <button type="submit" className="btn btn-sm btn-outline-danger" onClick={() => props.delete(id)}><i className="far fa-trash-alt"></i></button></> : ''
                        }
                    </div>
                </>
            )
        }
        class AlbumList extends React.Component {
            constructor(props){
                super(props);
                this.state = {
                    albums: JSON.parse(props.albums),
                    auth: props.auth,
                    count: props.count,
                    search: ''
                }
                console.log(JSON.parse(props.albums));
            }
            deleteAlbum = id => {
                // console.log(id);
                if(this.props.auth){
                    let albums = [...this.state.albums];
                    const index = albums.findIndex(album => album.id === id);
                    albums.splice(index,1);
                    this.setState({
                        albums,
                        count: this.state.count - 1
                    })
                    axios.delete(`albums/${id}`)
                        .then(res => res.data)
                        .catch(error => console.log(error));
                } else { console.log('zaloguj sie') };

            }
            search = e => {
                this.setState({
                    search: e.target.value.toLowerCase()
                })
            }
            render() {
                const { auth, count, search } = this.state;
                const { placeholder } = this.props;
                const albums = this.state.albums.filter(album => album.name.toLowerCase().includes(search));
                return (
                    <>
                        <div className="jumbotron text-white bg-dark">
                            <div className="row">
                                <div className="col-md-8">
                                    <h2>Lista albumów</h2>
                                    <h5>ilość albumów: {count} <div className="badge badge-pill badge-warning"></div>
                                    </h5>
                                </div>
                                <div className="col-md-4">
                                    <input type="text" className="form-control" placeholder="nazwa" onInput={this.search} />
                                </div>
                            </div>
                        </div>
                        {auth ? <a href="{{ route('albums.create') }}" className="btn btn-block btn-outline-success mb-2">dodaj album</a> : ''}
                        <div className="row">

                                {albums.map(album => (
                                    <AlbumItem
                                        key={album.id}
                                        album={album}
                                        auth={auth}
                                        placeholder={placeholder}
                                        delete={this.deleteAlbum}
                                    />
                                ))}

                        </div>
                    </>
                )
            }
        }
        let auth = document.getElementById('albums').getAttribute('auth');
        let placeholder = document.getElementById('albums').getAttribute('placeholder');
        let albums = document.getElementById('albums').getAttribute('albums');
        let count = document.getElementById('albums').getAttribute('count');
        ReactDOM.render(<AlbumList auth={auth} placeholder={placeholder} albums={albums} count={count} />, document.getElementById('albums'));
    </script>
@endsection
