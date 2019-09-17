@extends('layouts.app')
@section('title')
    @if($year ?? false)
        archiwum {{ $year }}
    @else
        lista artykułów
    @endif
@endsection

@section('content')
<div id="articles"
    articles="{{$articles}}"
    auth="{{Auth::user() && Auth::user()->hasRole(['admin'])}}"
    count="{{$articles->count()}}"
    tag="{{$tag ?? null}}"
    year="{{$year ?? null}}"
    category="{{$category ?? null}}"
    placeholder="{{$placeholder}}"
>
</div>
@endsection
{{-- {{ $article->path != null ? asset("storage/{$article->path}") : $placeholder }} --}}
@section('scripts')
<script type="text/babel">
const ArticleItem = props => {
    const {slug, title, path, id, storage_path} = props.article;
    // console.log(props.article);
    return (
        <tr>
            <td><a href={`/articles/${slug}`}><img width="35" height="25" src={ `${path}` === null ? `${props.placeholder}` : `${storage_path}/${path}` } alt="" title={ `${title}` } /></a></td>
            <td>{title}</td>
            <td><a href={`/articles/${slug}`}>czytaj...</a></td>
            {props.auth ?
            <>
                <td><a href={`articles/${slug}/edit`} className="btn btn-outline-primary btn-sm"><i className="far fa-edit"></i></a></td>
                <td><button type="submit" className="btn btn-outline-danger btn-sm" onClick={() => props.delete(slug)}><i className="far fa-trash-alt"></i></button></td>
            </> : ''
            }
        </tr>
    )
}
class ArticleList extends React.Component {
    constructor(props){
        super(props);
        this.state = {
            articles: JSON.parse(props.articles),
            count: props.count,
            tag: props.tag,
            category: props.category,
            search: ''
        }
        // console.log(props.auth);
        console.log(JSON.parse(props.articles));
        // console.log(props.placeholder);
    }
    deleteArticle = slug => {
        if(this.props.auth) {
            // console.log(id);
            let articles = [...this.state.articles];
            let index = articles.findIndex(article => article.slug === slug);
            articles.splice(index,1);
            this.setState({
                articles,
                count: this.props.count - 1
            });
            axios.delete(`articles/${slug}`)
                .then(res => res.data)
                .catch(error => console.log(error));

        } else {
            alert('zaloguj się');
        }
    }
    handleChange = e => {
        this.setState({
            search: e.target.value.toLowerCase()
        })
        // console.log(e.target.value);
    }
    render(){
        const {articles, count, tag, category, search} = this.state;
        const {auth, year, placeholder} = this.props;
        const searchArticles = articles.filter(article => (
            article.title.toLowerCase().includes(search) ||
            article.category.name.toLowerCase().includes(search)));
        return (
            <>
                <div className="jumbotron text-white bg-dark">
                    <div className="row">
                        <div className="col-md-8">
                            { year ? <h2>Archiwum: {year }</h2> :
                            <>
                                <h2>Lista artykułów</h2>
                                <h5>ilość artykułów: {count}</h5>
                            </>
                            }
                        </div>
                        <div className="col-md-4">
                            <input type="text" className="form-control" placeholder="tytuł lub kategoria" onInput={this.handleChange} />
                        </div>
                    </div>
                </div>
                {auth ? <a href="{{ route('articles.create') }}" className="btn btn-outline-success btn-block mb-2">dodaj artykuł</a> : null}
                <table className="table table-hover bg-dark text-white mb-4">
                    <thead>
                        <tr>
                            <th></th>
                            <th className="col-md-10">tytuł</th>
                            <th>artykuł</th>
                            {auth ? <>
                                <th>edytuj</th>
                                <th>usuń</th>
                                </> : ''}
                        </tr>
                    </thead>
                    <tbody>
                        {searchArticles.map(article => (
                            <ArticleItem
                                key={article.id}
                                article={article}
                                placeholder={placeholder}
                                auth={auth}
                                delete={this.deleteArticle}
                            />
                        ))}
                    </tbody>
                </table>
            </>
        )
    }
}
let articles = document.getElementById('articles').getAttribute('articles')
let auth = document.getElementById('articles').getAttribute('auth');
let count = document.getElementById('articles').getAttribute('count');
let tag = document.getElementById('articles').getAttribute('tag');
let year = document.getElementById('articles').getAttribute('year');
let category = document.getElementById('articles').getAttribute('category');
let placeholder = document.getElementById('articles').getAttribute('placeholder');
ReactDOM.render(<ArticleList
                    articles={articles}
                    auth={auth}
                    count={count}
                    tag={tag}
                    year={year}
                    category={category}
                    placeholder={placeholder}
                />,document.getElementById('articles'));
</script>
@endsection

