import React from "react";

const Header = props => {
    return (
        <div className="jumbotron text-white bg-dark">
            <div className="row">
                <div className="col-md-8">
                    <h2>Archiwum: </h2>
                    <h2>Lista artykułów</h2>
                    <h5>ilość artykułów:</h5>
                    <h5>
                        tag:{" "}
                        <div className="badge badge-pill badge-warning"></div>
                    </h5>
                    <h5>ilość artykułów:</h5>
                    <h5>
                        kategoria:{" "}
                        <div className="badge badge-pill badge-warning"></div>
                    </h5>
                    <h5>
                        ilość artykułów:{" "}
                        <div className="badge badge-pill badge-warning"></div>
                    </h5>
                    <h5>ilość artykułów na bieżacej stronie:</h5>
                </div>
                <div className="col-md-4">
                    <input
                        name="article"
                        type="text"
                        className="form-control"
                        id="article"
                        placeholder="Artykuł"
                    />
                </div>
            </div>
        </div>
    );
};

export default Header;
