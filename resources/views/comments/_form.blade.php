    <script type="text/babel">
        const CommentItem = props => {
            const { user, content, id, rating} = props.comment;
            const { name, path, storage_path } = user;
            // console.log(rating);
            // console.log(props.auth.role.map(r => r.name) == 'admin');
            // console.log(`${storage_path}/${path}`);
            return (
                <>
                    <div data-key={props.index}>
                        <img  src={ `${path}` !== "null" ? `${storage_path}/${path}` :  `${props.placeholder}`} alt="" height="30" width="25" align="left" className="mr-2 img-fluid" />
                        <h5> autor: {name}</h5>
                        <h5>{content}</h5>
                        { props.name === 'Article' ? <h5>ocena: {rating}</h5> : '' }
                        {props.auth && props.auth.role.map(r => r.name) == 'admin' ? <><a href={`/editComment/${id}`} className="btn btn-sm btn-outline-primary mr-2"><i className="far fa-edit"></i></a><button onClick={() => props.delete(id)} className="btn btn-sm btn-outline-danger"><i className="far fa-trash-alt"></i></button></> : ""}
                        <hr className="bg-warning" />
                    </div>
                </>
            )
        }
        class AddComment extends React.Component {
            constructor(props) {
                super(props);
                this.state = {
                    auth: props.auth ? JSON.parse(props.auth) : null,
                    model: JSON.parse(props.model),
                    isCommented: props.isCommented,
                    count: JSON.parse(props.count),
                    content: '',
                    rating: '',
                    comments: JSON.parse(props.comments),
                }
                // console.log(this.state.comments[this.state.comments.length - 1].id + 1);
                console.log(this.state.comments);
                // console.log(this.state.auth);
            }
            handleContent = e => {
                this.setState({
                    content: e.target.value
                })
            }
            handleRating = e => {
                this.setState({
                    rating: e.target.value
                })
            }
            addComment = (e) => {
                e.preventDefault();
                if(this.state.content.length <  20) return alert('wpisz komentarz > 20 znaków');

                const comments = [...this.state.comments];
                const comment = {
                    id: comments.length !== 0 ? comments[comments.length - 1].id + 1 : 1,
                    content: this.state.content,
                    rating: this.state.rating,
                    user: this.state.auth
                }
                this.setState(prevState => ({
                    count: prevState.count + 1,
                    isCommented: !prevState.Commented,
                    comments: [...prevState.comments, comment],
                    content: '',
                    rating: 1
                }))
                // console.log(this.state.count);
                axios.post(`/addComment/${this.state.model.id}/${this.props.name}`,{
                    content: this.state.content,
                    rating: this.state.rating
                    })
                    .then(response => response.data)
                    .catch(err => console.log(err));
            };
            deleteComment = id => {
                // console.log(id);
                let comments = [...this.state.comments];
                let index = comments.findIndex(comment => comment.id === id);
                comments.splice(index, 1);
                this.setState({
                    comments,
                    count: this.state.count - 1,
                    isCommented: !this.state.isCommented
                })
                axios.get(`/deleteComment/${id}`)
                    .then(res => res.data)
                    .catch(err => console.log(err));
            }

            render() {
                const {name, placeholder} = this.props;
                const {model, auth, isCommented, content, rating, count,comments} = this.state;
                let rows = [];
                for (let i = 1; i <= 5; i++) {
                    rows.push(
                        <option key={i} value={i}>
                            {i}
                        </option>
                    );
                }
                return (
                    <>
                        {auth  ? isCommented
                            ?
                                <div className="col-md-12 text text-danger">już dodałeś komentarz do tego {name}</div>
                            :
                                <div className="col-md-12">
                                    <div className="jumbotron bg-dark text-white"><h2>Dodaj komentarz</h2>
                                        <hr className="bg-warning" />
                                        <div className="form-group row">
                                            <div className="col-md-12">
                                                <textarea name="content" cols="30" rows="10" className="form-control" value={content} onChange={this.handleContent} placeholder="treść:"></textarea>
                                            </div>
                                        </div>
                                        { name === 'Article' ?
                                            <div className="form-group row">
                                                <label htmlFor="rating" className="col-md-2 col-form-label text-lg-right">ocena:</label>
                                                <div className="col-md-10">
                                                    <select className="form-control" onChange={this.handleRating}>
                                                        <option>wybierz rating</option>
                                                        {rows}
                                                    </select>
                                                </div>
                                            </div> : '' }
                                        <div className="form-group row">
                                            <div className="col-md-12">
                                                <button className="btn btn-block btn-outline-warning" onClick={this.addComment}>dodaj komentarz</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            :
                            <div className="col-md-12"><a href="{{ route('login') }}">zaloguj się aby dodać komentarz</a></div>
                        }
                        <div className="col-md-12">
                            <div className="jumbotron bg-dark text-white">
                                <h2>komentarze <div className="badge badge-pill badge-warning">{count}</div></h2>
                                <hr className="bg-warning"/>

                                {comments.map((comment, index) => (
                                    <CommentItem
                                        key={comment.id}
                                        comment={comment}
                                        placeholder={placeholder}
                                        auth={auth}
                                        delete={this.deleteComment}
                                        index={index}
                                        name={name}
                                    />
                                ))}
                            </div>
                        </div>
                    </>
                )
            }
        }
        let auth = document.getElementById('addComment').getAttribute('auth');
        let isCommented = document.getElementById('addComment').getAttribute('isCommented');
        let name = document.getElementById('addComment').getAttribute('name');
        let model = document.getElementById('addComment').getAttribute('model');
        let count = document.getElementById('addComment').getAttribute('count');
        let comments = document.getElementById('addComment').getAttribute('comments');
        let placeholder = document.getElementById('addComment').getAttribute('placeholder');
        let incr = document.getElementById('addComment').getAttribute('incr');

        ReactDOM.render(<AddComment auth={auth} isCommented={isCommented} model={model} name={name} count={count} comments={comments} placeholder={placeholder} incr={incr} />, document.getElementById('addComment'));
    </script>


