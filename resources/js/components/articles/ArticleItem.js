import React from "react";

const ArticleItem = props => {
    const { title } = props.article;
    return (
        <tr>
            <td>{props.index + 1}</td>
            <td>{title}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    );
};

export default ArticleItem;
