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
			bricks.push(new Brick(canvas, current_x, current_y, 
						BRICK_BKG[i-1], 
						BRICK_BKG_S[i-1], 
						BRICK_W, BRICK_H, 
						BRICK_SCORES[i-1]));
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
		bricks[index] = 0;
		
		numHits += 1;
		if (numHits == 4 || numHits == 12){
			increaseBallSpeed();
		}
		
		if ((row == 2 || row == 3) && (!speedIncreaseOrangeRow)){
			speedIncreaseOrangeRow = true;
			increaseBallSpeed();
		}
		if ((row == 0 || row == 1) && (!speedIncreaseRedRow)){
			speedIncreaseRedRow = true;
			increaseBallSpeed();
		}
		return true;
	}            
	return false;
};

function testHitPaddle() {
	if (!balls.length) return false;	
	var x_min = paddle.x;
	var x_max = paddle.x + paddle.width;
	var y = paddle.y;
	var ball_bottom = balls[0].y + balls[0].radius;
	return ydirection > 0 && balls[0].x >= x_min && balls[0].x <= x_max && ball_bottom >= y;
};


function movePaddle(evt) {
	if (evt.keyCode == 39) rightKeyPressed = true;
	else if (evt.keyCode == 37) leftKeyPressed = true;
	else if (evt.keyCode == 13) {
		if (balls.length) {
			if (playing) gameStop();
			else { 
				gameStart();
				ballsSpan.html("Balls left: " + balls.length);
			}
		} else {
			resetBoard();
			score = 0;
			//gameStart();
			ballsSpan.html("Press ENTER to start/pause the game.");
			scoreSpan.html("Score: " + score);
		}
	}
	else return;
};

function stopMovingPaddle(evt) {
	if (evt.keyCode == 39) rightKeyPressed = false;
	else if (evt.keyCode == 37) leftKeyPressed = false;
	else return;
};

function shrinkPaddle(){
	smallPaddle = true;
	paddle.shrinkSize();
}

function increaseBallSpeed(){
	if (xdirection > 0){
		xdirection += 2;
	} else {
		xdirection -= 2;
	}
	
	if (ydirection >0){
		ydirection += 2;
	} else  {
		ydirection -= 2;
	}
	
	paddle.speed += 3;
}


function drawAll() {
	canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
	drawBricks(bricks);
	balls[0].draw();
	paddle.draw();
};

// clear the board and reset
function resetBoard() {	
	var numHits = 0;
	var speedIncreaseOrangeRow = false;
	var speedIncreaseRedRow = false;
	
	bricks = newBricks(BRICK_ROWS, BRICK_COLS);
	balls = newBalls(3);
	paddle = new Paddle(canvas, (canvas.width / 2) - (PADDLE_W/ 2), PADDLE_I, PADDLE_W, PADDLE_H);
	drawAll();
};

function levelCheck() {
	var sum;
	for (var i = 0; i < bricks.length; i++) { sum += bricks[i];} // will either be 0 or a string
	if (!sum) {
		if (score == LEVEL_SCORE) {
			resetBoard();
			gameStop();
			ballsSpan.html("LEVEL 2");
			return true;
		} else if (score == LEVEL_SCORE * 2) {
			gameStop();
			scoreSpan.html("WINNER");
			ballsSpan.html("Press ENTER to play again.");
			return true;
		}
	}
	return false;
};

function onLose(){
	balls.shift();
	if (balls.length) {
		paddle.x = (canvas.width / 2) - (paddle.width/ 2);
		ballsSpan.html("Press ENTER to continue.");
	} else {
		scoreSpan.html("GAME OVER");
		ballsSpan.html("Press ENTER to play again.");
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
				if (!balls.length) return;
			}
		} else {
			ydirection *= -1;
		}
		if (!levelCheck()) drawAll();
	}
};

$(function() {
	scoreSpan = $("#score");
	scoreSpan.html("Score: " + score);
		
	ballsSpan = $("#balls");

	canvas = $("#game-window")[0];
	var ctx = canvas.getContext("2d");
	resetBoard();	
	$(document).keydown(movePaddle);
	$(document).keyup(stopMovingPaddle);
	ballsSpan.html("Press ENTER to start/pause the game.");
});

