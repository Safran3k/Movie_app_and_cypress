package org.example;

import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;
import java.util.List;


public class Main {
    public static void main(String[] args) {
        WebDriver driver = new FirefoxDriver();
        driver.get("http://127.0.0.1:8000/");

        titleTest(driver);
        navigationTest(driver);
        selectFirstPopularMovieTest(driver);
        selectFirstPopularTVShowTest(driver);
        searchBarTest(driver);
        addMovieToMyListTest(driver);
        deleteMovieFromMyListTest(driver);
        playMovieTrailer(driver);

        driver.quit();
    }

    public  static  void titleTest(WebDriver driver){
        WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

        String expectedTitle = "Movie App";
        String actualTitle = driver.getTitle();

        if (actualTitle.equals(expectedTitle)) {
            System.out.println("Correct title: " + actualTitle);
        } else {
            System.out.println("Incorrect title. The expected title is: " + expectedTitle + ", and the actual title is: " + actualTitle);
        }
    }
    public static void navigationTest(WebDriver driver) {
        WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

        WebElement moviesLink = driver.findElement(By.linkText("Movies"));
        moviesLink.click();
        if (wait.until(ExpectedConditions.urlToBe("http://127.0.0.1:8000/"))) {
            System.out.println("Successfully navigate to Movies page.");
        }

        driver.get("http://127.0.0.1:8000");
        WebElement tvShowsLink = driver.findElement(By.linkText("TV Shows"));
        tvShowsLink.click();
        if (wait.until(ExpectedConditions.urlToBe("http://127.0.0.1:8000/tv"))) {
            System.out.println("Successfully navigate to TV Shows page.");
        }

        driver.get("http://127.0.0.1:8000");
        WebElement actorsLink = driver.findElement(By.linkText("Actors"));
        actorsLink.click();
        if (wait.until(ExpectedConditions.urlToBe("http://127.0.0.1:8000/actors"))) {
            System.out.println("Successfully navigate to Actors page.");
        }

        driver.get("http://127.0.0.1:8000");
        WebElement myListLink = driver.findElement(By.linkText("My List"));
        myListLink.click();
        if (wait.until(ExpectedConditions.urlToBe("http://127.0.0.1:8000/mylist"))) {
            System.out.println("Successfully navigate to My List page.");
        }
    }
    public  static  void selectFirstPopularMovieTest(WebDriver driver) {
        WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

        WebElement moviesLink = driver.findElement(By.linkText("Movies"));
        moviesLink.click();
        wait.until(ExpectedConditions.urlToBe("http://127.0.0.1:8000/"));
        WebElement popularMoviesSection = driver.findElement(By.id("popular-movie-container"));
        List<WebElement> popularMovies = popularMoviesSection.findElements(By.className("mt-8"));

        if (!popularMovies.isEmpty()) {
            WebElement selectedMovie = popularMovies.get(0);
            selectedMovie.click();
        } else {
            System.out.println("There are no movies available in the Popular Movies list.");
        }
    }
    public  static  void selectFirstPopularTVShowTest(WebDriver driver) {
        WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

        WebElement tvShowsLink = driver.findElement(By.linkText("TV Shows"));
        tvShowsLink.click();
        wait.until(ExpectedConditions.urlToBe("http://127.0.0.1:8000/tv"));
        WebElement popularTVShowsSection = driver.findElement(By.id("popular-tv-shows-container"));
        List<WebElement> popularTVShows = popularTVShowsSection.findElements(By.className("mt-8"));

        if (!popularTVShows.isEmpty()) {
            WebElement selectedMovie = popularTVShows.get(0);
            selectedMovie.click();
        } else {
            System.out.println("There are no tv shows available in the Popular TV Shows list.");
        }
    }
    public static void searchBarTest(WebDriver driver) {
        WebElement searchInput = driver.findElement(By.id("search-input"));
        searchInput.sendKeys("Thor");
        searchInput.sendKeys(Keys.ENTER);

        WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(3));
        wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector(".dropdown-item")));
        WebElement firstSearchResult = driver.findElement(By.cssSelector(".dropdown-item ul li:first-child"));
        firstSearchResult.click();

        searchInput = driver.findElement(By.id("search-input"));
        searchInput.clear();
        searchInput.sendKeys("asdgadg");
        searchInput.sendKeys(Keys.RETURN);
        wait.until(ExpectedConditions.textToBePresentInElementLocated(By.cssSelector(".no-result-message"), "No results for asdgadg"));
    }
    public static void addMovieToMyListTest(WebDriver driver) {
        driver.get("http://127.0.0.1:8000/mylist");
        driver.get("http://127.0.0.1:8000");
        WebElement popularMoviesSection = driver.findElement(By.id("popular-movie-container"));
        List<WebElement> popularMovies = popularMoviesSection.findElements(By.className("mt-8"));

        if (!popularMovies.isEmpty()) {
            WebElement selectedMovie = popularMovies.get(0);
            selectedMovie.click();
        } else {
            System.out.println("There are no movies available in the Popular Movies list.");
        }

        WebElement addToMyListButton = driver.findElement(By.className("add-to-my-list"));
        addToMyListButton.click();
        driver.get("http://127.0.0.1:8000/mylist");
    }
    public static void deleteMovieFromMyListTest(WebDriver driver) {
        driver.get("http://127.0.0.1:8000/mylist");
        List<WebElement> myListMovies = driver.findElements(By.id("my-list-container"));

        if (!myListMovies.isEmpty()) {
            WebElement firstMyListItemLink = myListMovies.get(0);
            firstMyListItemLink.click();
            WebElement deleteFromMyListButton = driver.findElement(By.className("delete-my-list-item"));
            deleteFromMyListButton.click();
            driver.get("http://127.0.0.1:8000/mylist");
        } else {
            System.out.println("There are no movies available in My List Movies.");
        }
    }
    public  static void playMovieTrailer(WebDriver driver) {
        driver.get("http://127.0.0.1:8000");
        WebElement popularMoviesSection = driver.findElement(By.id("popular-movie-container"));
        List<WebElement> popularMovies = popularMoviesSection.findElements(By.className("mt-8"));

        if (!popularMovies.isEmpty()) {
            WebElement selectedMovie = popularMovies.get(0);
            selectedMovie.click();

            WebElement playTrailerButton = driver.findElement(By.className("play-trailer"));
            playTrailerButton.click();

        } else {
            System.out.println("There are no movies available in the Popular Movies list.");
        }
    }
}