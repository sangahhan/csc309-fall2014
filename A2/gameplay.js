function drawBricks(bricks) {
	for (var i = 0; i < bricks.length; i++) {
		if (bricks[i]) bricks[i].draw();
	}
};

function newBricks(rows, cols) {
	var bricks = [];
	var current_x = 0;
	var current_y = 0;
	for (var i = BRICK_ROWS; i > 0; i--) {
		for (var j = 0; j < cols; j++) {
			bricks.push(new Brick(canvas, current_x, current_y, BRICK_I[i-1], BRICK_W, BRICK_H, BRICK_SCORES[i-1]));
			current_x += BRICK_W;
		}
		current_y += BRICK_H;
		current_x = 0;
	}
	return bricks;
};

function newBalls(num) {
	var balls = [];
	var x = (canvas.width / 2);
	var y = canvas.height - PADDLE_H - BALL_R;
	for (var i = 0; i < num; i++) {
		balls.push(new Ball(canvas, x, y, BALL_I, BALL_R));
	}
	return balls;
};

function testHitBricks() {
	if (!bricks.length) return false; 
	var row = Math.floor(balls[0].y/BRICK_H);
	var col = Math.floor(balls[0].x/BRICK_W);
	var index = col + (row * BRICK_COLS)
	if (balls[0].y < BRICK_ROWS * BRICK_H && row >= 0 && col >= 0 && bricks[index]) {
		ydirection *= -1;
		score += bricks[index].score;
		bricks[index] = null;
		return true;
	}            
	return false;
};

function testHitPaddle() {
	if (!balls.length) return false;	
	var x_min = paddle.x;
	var x_max = paddle.x + PADDLE_W;
	var y = paddle.y;
	var ball_bottom = balls[0].y + balls[0].radius;
	return ydirection > 0 && balls[0].x >= x_min && balls[0].x <= x_max && ball_bottom >= y;
};


function movePaddle(evt) {
	if (evt.keyCode == 39) rightKeyPressed = true;
	else if (evt.keyCode == 37) leftKeyPressed = true;
	else if (evt.keyCode == 38 && !playing && balls.length) {
		gameStart();
	}
	else return;
};

function stopMovingPaddle(evt) {
	if (evt.keyCode == 39) rightKeyPressed = false;
	else if (evt.keyCode == 37) leftKeyPressed = false;
	else return;
};

function drawAll() {
	canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
	drawBricks(bricks);
	balls[0].draw();
	paddle.draw();
};

// clear the board and reset
function resetBoard() {	
	bricks = newBricks(BRICK_ROWS, BRICK_COLS);
	balls = newBalls(3);
	paddle = new Paddle(canvas, (canvas.width / 2) - (PADDLE_W/ 2), PADDLE_I, PADDLE_W, PADDLE_H);
	drawAll();
};

function displayWinner() {
};

function levelCheck() {
	if (score == 128) {
		resetBoard();
	} else if (score >= 256) {
		gameStop();

	}
};

function onLose(){
	balls.shift();
	if (balls.length) {
		paddle.x = (canvas.width / 2) - (PADDLE_W/ 2);
		$("#balls").html("Balls left: " + balls.length);
	} else {
		scoreSpan.html("GAME OVER");
		$("#balls").html("");
	}
	gameStop();
};

function gameStop() {
	playing = false;
	clearInterval(interval);
};

function gameStart() {
	playing = true;
	interval = setInterval("gameRun()", 30);
};

// Let's put all the if statements and magic up in hurr
function gameRun() {
	if (playing) {
		if (testHitBricks()) scoreSpan.html("Score: " + score);
		if (!testHitPaddle()) {
			if (balls[0].y >= (canvas.height - paddle.height)) {
				onLose();
			// TODO: Ball has hit the ground. We must give them a new ball from the list balls. (teehee)
			// If there are no balls left, tell them they have lost.
			// Should we let them try again and reset the entire board?
			}
		} else {
			ydirection *= -1;
		}
		levelCheck();
		drawAll();
	}
};

$(function() {
	scoreSpan = $("#score");
	scoreSpan.html("Score: " + score);
	
	canvas = $("#game-window")[0];
	var ctx = canvas.getContext("2d");
	resetBoard();	
	$(document).keydown(movePaddle);
	$(document).keyup(stopMovingPaddle);
	gameStart();
	$("#balls").html("Balls left: " + balls.length);
});

