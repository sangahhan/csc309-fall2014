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
	for (var i = 0; i < bricks.length; i++) {
		if (bricks[i]) {
			if (bricks[i].testHit(balls[0]))  {
				score += bricks[i].score;
				bricks[i] = null;
				ydirection *= -1;
				xdirection *= -1;
				return true;
			}
		}
	}
	return false;
};

function testHitPaddle() {
	if (!balls.length) return false;
	
	/*We don't care if the ball hits the paddle if it is in the
	middle of the screen */
	if (balls[0].y < canvas.height - PADDLE_H) return true;
	
	var x_min = paddle.x;
	var x_max = paddle.x + PADDLE_W;
	var y = paddle.y;
	var ball_bottom = balls[0].y + balls[0].radius;
	return balls[0].x >= x_min && balls[0].x <= x_max && ball_bottom >= y;
};


function movePaddle(evt) {
	if (evt.keyCode == 39) rightKeyPressed = true;
	else if (evt.keyCode == 37) leftKeyPressed = true;
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
	paddle = new Paddle(canvas, canvas.width / 2, PADDLE_I, PADDLE_W, PADDLE_H);
	drawAll();
};

function levelCheck() {
	if (score == 128) {
		resetBoard();
	} else if (score == 256) {
		scoreSpan.html("WINNER");
		gameStop();
	}
};

function gameStop() {
	clearInterval(interval);
};

// Let's put all the if statements and magic up in hurr
function gameStart() {
	if (testHitBricks()) scoreSpan.html(score);
	
	if (!testHitPaddle()) {
		if (balls[0].y >= canvas.height) {
			gameStop();
			// TODO: click to play again?
			console.log(interval);
		}
	}
	levelCheck();
	drawAll();
};

$(function() {
	scoreSpan = $("#score");
	scoreSpan.html(score);
	
	canvas = $("#game-window")[0];
	var ctx = canvas.getContext("2d");
	playing = true;
	resetBoard();	
	interval = setInterval("gameStart()", 20);
	$(document).keydown(movePaddle);
	$(document).keyup(stopMovingPaddle);
});

