describe("Movie App Tests", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000");
    });

    it("Navigation test", () => {
        cy.visit("http://127.0.0.1:8000");
        cy.contains("Movies").click();
        cy.url().should("eq", "http://127.0.0.1:8000/");
        cy.contains("Movies");

        cy.visit("http://127.0.0.1:8000/tv");
        cy.contains("TV Shows").click();
        cy.url().should("eq", "http://127.0.0.1:8000/tv");
        cy.contains("TV Shows");

        cy.visit("http://127.0.0.1:8000/actors");
        cy.contains("Actors").click();
        cy.url().should("eq", "http://127.0.0.1:8000/actors");
        cy.contains("Actors");

        cy.visit("http://127.0.0.1:8000/mylist");
        cy.contains("My List").click();
        cy.url().should("eq", "http://127.0.0.1:8000/mylist");
        cy.contains("My List");
    });

    it("Select first movie/tv show/actor/my list item test", () => {
        // First popular movie
        cy.visit("http://127.0.0.1:8000");
        cy.get("#popular-movie-container a")
            .first()
            .then(($link) => {
                const popularMovieUrl = $link.prop("href");
                cy.visit(popularMovieUrl);
            });

        cy.visit("http://127.0.0.1:8000");
        cy.get("#now-playing-movie-container a")
            .first()
            .then(($link) => {
                const nowPlayingMovieUrl = $link.prop("href");
                cy.visit(nowPlayingMovieUrl);
            });

        cy.visit("http://127.0.0.1:8000/tv");
        cy.get("#popular-tv-shows-container a")
            .first()
            .then(($link) => {
                const popularTVShowUrl = $link.prop("href");
                cy.visit(popularTVShowUrl);
            });

        cy.visit("http://127.0.0.1:8000/tv");
        cy.get("#top-rated-tv-shows-container a")
            .first()
            .then(($link) => {
                const topRatedTVShowUrl = $link.prop("href");
                cy.visit(topRatedTVShowUrl);
            });

        // Ha be lenne fejezve az oldal akkor megnyílna...
        cy.visit("http://127.0.0.1:8000/actors");
        cy.get("#popular-actors-container a")
            .first()
            .then(($link) => {
                const popularActorUrl = $link.prop("href");
                cy.visit(popularActorUrl);
            });

        cy.visit("http://127.0.0.1:8000/mylist");
        cy.get("#my-list-container a")
            .first()
            .then(($link) => {
                const myListUrl = $link.prop("href");
                cy.visit(myListUrl);
            });
    });

    it("Search bar test test", () => {
        cy.get("#search-input").type("Thor", { delay: 1000 });
        cy.get(".dropdown-item").should("exist", { timeout: 10000 });
        cy.wait(1000);
        cy.get(":nth-child(1) > .block").click();

        cy.get("#search-input").type("asdgadg", { delay: 1000 });
        cy.get(".dropdown-item").should("exist", { timeout: 10000 });
        cy.wait(1000);
        cy.get(".no-result-message").should(
            "contain",
            "No results for asdgadg"
        );
    });

    it("Add a movie to my list test", () => {
        cy.visit("http://127.0.0.1:8000/mylist");
        cy.wait(5000);
        cy.visit("http://127.0.0.1:8000");
        cy.get("#popular-movie-container a")
            .first()
            .then(($link) => {
                const popularMoviesUrl = $link.prop("href");
                cy.visit(popularMoviesUrl);
            });
        cy.get(".add-to-my-list").click();
        cy.visit("http://127.0.0.1:8000/mylist");
    });

    it("Delete a movie from my list test", () => {
        cy.visit("http://127.0.0.1:8000/mylist");
        cy.get("#my-list-container a")
            .first()
            .then(($link) => {
                const myListItemUrl = $link.prop("href");
                cy.visit(myListItemUrl);
            });
        cy.get(".delete-my-list-item").click();
        cy.visit("http://127.0.0.1:8000/mylist");
    });

    it("Play a TV Show trailer test", () => {
        cy.visit("http://127.0.0.1:8000/tv");
        cy.get("#popular-tv-shows-container a")
            .first()
            .then(($link) => {
                const popularTVShowUrl = $link.prop("href");
                cy.visit(popularTVShowUrl);
            });
        cy.get(".play-trailer").click();
    });
});
