import React, { Component } from "react";
import axios from "axios";
import ReactDOM from "react-dom";

class Like extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isLiked: props.isLiked,
            auth: props.auth,
            article: JSON.parse(props.article),
            count: JSON.parse(props.count)
        };
        console.log(props);
    }
    handleLike = e => {
        e.preventDefault();
        this.setState({
            isLiked: !this.state.isLiked,
            count: this.state.count + 1
        });
        // console.log(this.state.isLiked);
        axios
            .get(`/like/${this.state.article.id}/Article`)
            .then(response => response.data)
            .catch(error => console.log(error));
    };
    handleUnlike = e => {
        e.preventDefault();
        this.setState({
            isLiked: !this.state.isLiked,
            count: this.state.count - 1
        });
        // console.log(this.state.isLiked);
        axios
            .get(`/unlike/${this.state.article.id}/Article`)
            .then(response => response.data)
            .catch(error => console.log(error));
    };
    render() {
        const { auth, isLiked, count } = this.state;
        return (
            <>
                <h4>
                    <i className="far fa-thumbs-up fa-lg"></i>{" "}
                    <div className="badge badge-pill badge-danger">{count}</div>
                </h4>
                {auth ? (
                    isLiked ? (
                        <button className="btn btn-primary">
                            <i
                                className="far fa-thumbs-down fa-lg"
                                onClick={this.handleLike}
                            ></i>
                        </button>
                    ) : (
                        <button
                            className="btn btn-primary"
                            onClick={this.handleUnlike}
                        >
                            <i className="far fa-thumbs-up fa-lg"></i>
                        </button>
                    )
                ) : (
                    <a href="{{ route('login') }}">
                        zaloguj się aby ocenić artykuł
                    </a>
                )}
            </>
        );
    }
}
export default Like;

let article = document.getElementById("like").getAttribute("article");
let isLiked = document.getElementById("like").getAttribute("isLiked");
let auth = document.getElementById("like").getAttribute("auth");
let count = document.getElementById("like").getAttribute("count");
ReactDOM.render(
    <Like count={count} article={article} isLiked={isLiked} auth={auth} />,
    document.getElementById("like")
);
