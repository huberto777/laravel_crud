import React, { Component } from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import ArticleItem from "./ArticleItem";
import Header from "./Header";

class ArticleList extends Component {
    constructor(props) {
        super(props);
        let articles = JSON.parse(props.articles);
        this.state = {
            articles: [
                // articles
                // { id: 1, title: "gdfgd", content: "cuidb jigfbi" },
                // { id: 2, title: "gdfgd", content: "cuidb jigfbi" },
                // { id: 3, title: "gdfgd", content: "cuidb jigfbi" }
            ]
        };
        // console.log(JSON.parse(props.articles));
    }

    componentDidMount() {
        axios.get("/articles").then(response => {
            this.setState({
                articles: response.data
            });
        });
    }

    render() {
        const { articles } = this.state;
        return (
            <>
                <Header />
                <table className="table table-hover bg-dark text-white mb-4">
                    <thead>
                        <tr>
                            <th>l.p.</th>
                            <th className="col-md-10">tytuł</th>
                            <th>artykuł</th>
                            <th>edytuj</th>
                            <th>usuń</th>
                        </tr>
                    </thead>

                    <tbody>
                        {articles.map((article, i) => (
                            <ArticleItem
                                key={article.id}
                                article={article}
                                index={i}
                            />
                        ))}
                    </tbody>
                </table>
            </>
        );
    }
}

export default ArticleList;

if (document.getElementById("articleList")) {
    ReactDOM.render(<ArticleList />, document.getElementById("articleList"));
}
// if (document.getElementById("articleList")) {
//     let articles = document
//         .getElementById("articleList")
//         .getAttribute("articles");
//     ReactDOM.render(
//         <ArticleList articles={articles} />,
//         document.getElementById("articleList")
//     );
// }
// @include('answers._answer', [
//     'answer' => $answer
// ])
