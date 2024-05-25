<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snake Game</title>
</head>
<style>
    #mainPart {
        width: 90%;
        text-align: center;
        margin-top: 20px;
        color: black;
        margin-left: 60px;
    }

    a {
        text-decoration: none;
        color: darkblue;
        margin: 40px 0px 40px 560px;
        font-size: 40px;
    }

    @media only screen and (max-width: 600px) {
        #mainPart {
            width: 200px;
            margin-left: 35px;
        }

        a {
            margin: 20px 0px 20px 190px;
            font-size: 30px;
        }

        #game_field {
            width: 400px;
            height: 400px;
        }
    }
</style>

<body>
    <a href="my.php">WRÓĆ</a>
    <div id="mainPart">
        <canvas id="game_field" width="500px" height="500px" style="border: 3px solid rgb(174, 200, 236);"></canvas>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const canvas = document.getElementById("game_field");
            const context = canvas.getContext("2d");
            const width = canvas.width;
            const height = canvas.height;

            const CELLS_COUNT = 20;
            const CELL_SIZE = Math.round(width / CELLS_COUNT);

            let snake = []; // Tablica przechowująca pozycje węża
            let food = null; // Pozycja jedzenia
            let dir = null; // Kierunek poruszania się węża
            let score = 0; // Wynik gracza
            let speedCoeff = 1; // Współczynnik prędkości gry

            const FIELD_COLOR = "white";
            const FOOD_COLOR = "red"; 
            const GRID_COLOR = "rgb(174, 200, 236)";
            const SNAKE_COLOR = "darkblue";

            addEventListener("keydown", function (e) {
                if (e.keyCode === 37 && dir !== "right") {
                    dir = "left"; 
                } else if (e.keyCode === 38 && dir !== "down") {
                    dir = "up"; 
                } else if (e.keyCode === 39 && dir !== "left") {
                    dir = "right"; 
                } else if (e.keyCode === 40 && dir !== "up") {
                    dir = "down"; 
                }
            });

            const draw = function () {
                draw_field();
                draw_snake();
                draw_food();
            };

            const draw_field = function () {
                context.fillStyle = FIELD_COLOR;
                context.fillRect(0, 0, width, height);
                context.strokeStyle = GRID_COLOR;
                for (let i = CELL_SIZE; i < height; i += CELL_SIZE) {
                    context.moveTo(0, i);
                    context.lineTo(width, i);
                    context.stroke();
                }
                for (let i = CELL_SIZE; i < width; i += CELL_SIZE) {
                    context.moveTo(i, 0);
                    context.lineTo(i, height);
                    context.stroke();
                }
            };


            const draw_food = function() { 
            context.beginPath(); // Rozpoczęcie rysowania
            context.fillStyle = FOOD_COLOR; // Ustawienie koloru jedzenia
            context.arc(food.x + CELL_SIZE / 2, food.y + CELL_SIZE / 2, CELL_SIZE / 2, 0, 2 * Math.PI); // Rysowanie okręgu jako jedzenia
            context.fill(); // Wypełnienie jedzenia kolorem
            context.closePath(); // Zakończenie rysowania
          };

            const draw_snake = function() {
            context.fillStyle = SNAKE_COLOR; // Ustawienie koloru węża
            context.strokeStyle = "#000000"; // Ustawienie koloru obramowania węża
            for (let i = 0; i < snake.length; i++) { // Pętla rysująca każdy segment węża
              context.fillRect(snake[i].x, snake[i].y, CELL_SIZE, CELL_SIZE);
              context.strokeRect(snake[i].x, snake[i].y, CELL_SIZE, CELL_SIZE);
            }
          };

            const init = function () {
                snake = [];
                for (let i = 0; i < 2; ++i) {
                    snake.push({
                        x: i * CELL_SIZE,
                        y: 0
                    });
                    snake.reverse(); 
                }
                dir = "right";
                score = 0;
                speedCoeff = 1;
                spawn_food();
            };

            const isContact = function (fieldObj) {
                let contact = false;
                for (let i = 0; i < snake.length && !contact; i++) {
                    contact = snake[i].x === fieldObj.x && snake[i].y === fieldObj.y;
                }
                return contact;
            };

            const isValid = function (pos) {
                return 0 <= pos.x && pos.x < width && 0 <= pos.y && pos.y < height;
            }

            const spawn_food = function () {
                do {
                    food = {
                        x: Math.floor(
                            Math.round(Math.random() * width) / CELL_SIZE) * CELL_SIZE,
                        y: Math.floor(
                            Math.round(Math.random() * height) / CELL_SIZE) * CELL_SIZE
                    }
                } while (isContact(food) || !isValid(food))
            };

            const step = function () {
            let newPos = {};
            if (dir === "up") {
                newPos = {
                    x: snake[0].x,
                    y: snake[0].y - CELL_SIZE
                };
            } else if (dir === "right") {
                newPos = {
                    x: snake[0].x + CELL_SIZE,
                    y: snake[0].y
                };
            } else if (dir === "down") {
                newPos = {
                    x: snake[0].x,
                    y: snake[0].y + CELL_SIZE
                };
            } else if (dir === "left") {
                newPos = {
                    x: snake[0].x - CELL_SIZE,
                    y: snake[0].y
                };
            }

            
            if (newPos.x < 0) {
                newPos.x = width - CELL_SIZE;
            } else if (newPos.x >= width) {
                newPos.x = 0;
            } else if (newPos.y < 0) {
                newPos.y = height - CELL_SIZE;
            } else if (newPos.y >= height) {
                newPos.y = 0;
            }

            if (isContact(newPos)) {
                alert("Koniec gry, twoj score" + score);
                init();
            } else if (newPos.x === food.x && newPos.y === food.y) {
                score++;
                if (score == 6) {
                    alert("Wygrałeś! Twoje hasło do Wi-Fi: 40PUNKTOW");
                    init();
                } else {
                    if (score % 5 === 0) {
                        speedCoeff += 0.25;
                    }
                    spawn_food();
                    snake.unshift({
                        x: newPos.x,
                        y: newPos.y
                    });
                }
            } else {
                snake.pop();
                snake.unshift({
                    x: newPos.x,
                    y: newPos.y
                });
            }
            draw();
            setTimeout(step, 200 / speedCoeff);
        };


            init();
            step();
        });
    </script>
</body>

</html>
