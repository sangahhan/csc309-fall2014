// Draw the bricks all pretty at the top
function drawBricks(bricks) {
	for (var i = 0; i < bricks.length; i++) {
		for (var j = 0; j < bricks[i].length; j++) {
			if (bricks[i][j]) bricks[i][j].draw();
		}
	}
};

function newBricks(rows, cols) {
	var bricks = [];
	var current_x = 0;
	var current_y = 0;
	for (var i = BRICK_ROWS; i > 0; i--) {
		var row = [];
		for (var j = 0; j < cols; j++) {
			row.push(new Brick(canvas, current_x, current_y, BRICK_I[i-1], BRICK_W, BRICK_H, BRICK_SCORES[i-1]));
			current_x += BRICK_W;
		}
		current_y += BRICK_H;
		current_x = 0;
		bricks.push(row);
	}
	return bricks;
};

function newBalls(num) {
	var balls = [];
	var x = (canvas.width / 2) - (BALL_D / 2);
	var y = canvas.height - PADDLE_H - BALL_D;
	for (var i = 0; i < num; i++) {
		balls.push(new Ball(canvas, x, y, BALL_I, BALL_D));
	}
	return balls;
};

function testHitBricks() {
	if (!bricks.length) return false; 
	for (var i = 0; i < bricks.length; i++) {
		for (var j = 0; j < bricks[i].length; j++) {
			var current = bricks[i][j];
			if (current) {
			if (current.testHit(balls[0]))  {
				score += current.score;
				bricks[i][j] = null;
				return true;
			}}
		}
	}
	return false;
};

function testHitPaddle() {
	if (!balls.length) return false;
	
	/*We don't care if the ball hits the paddle if it is in the
	middle of the screen */
	if (balls[0].y < canvas.height - PADDLE_H - BALL_D) return true;
	
	var x_min = paddle.x;
	var x_max = paddle.x + PADDLE_W;
	var y = paddle.y;
	var ball_centre_x = balls[0].x + (balls[0].width / 2);
	var ball_bottom = balls[0].y + balls[0].height;
	return ball_centre_x >= x_min && ball_centre_x <= x_max && ball_bottom <= y;
};


function movePaddle(evt) {
	if (evt.keyCode == 39) rightKeyPressed = true;
	else if (evt.keyCode == 37) leftKeyPressed = true;
	else return;
}

function stopMovingPaddle(evt) {
	if (evt.keyCode == 39) rightKeyPressed = false;
	else if (evt.keyCode == 37) leftKeyPressed = false;
	else return;
}

function drawAll() {
	canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
	drawBricks(bricks);
	balls[0].draw();
	paddle.draw();
}

// clear the board and reset
function resetBoard() {	
	bricks = newBricks(BRICK_ROWS, BRICK_COLS);
	balls = newBalls(3);
	paddle = new Paddle(canvas, canvas.width / 2, PADDLE_I, PADDLE_W, PADDLE_H);
	drawAll();
};

function levelCheck() {
	if (score == 448) {
		resetBoard();
	} else if (score == 896) {
		scoreSpan.innerHTML = "WINNER";
		gameStop();
	}
};

function gameStop() {
	clearInterval(interval);
}

// Let's put all the if statements and magic up in hurr
function gameStart() {
	if (testHitBricks()) scoreSpan.innerHTML = score;
	
	//What is this for?
	if (testHitPaddle()) console.log("put ball bounce code here");
	
	if (!testHitPaddle()){
		gameStop();
	}
	levelCheck();
	drawAll();
};

window.onload = function() {
	scoreSpan = document.getElementById("score");
	scoreSpan.innerHTML = score;
	
	canvas = document.getElementById("game-window");
	var ctx = canvas.getContext("2d");

	paddle = new Paddle(canvas, 400, PADDLE_I, PADDLE_W, PADDLE_H);
	balls = [new Ball(canvas, (canvas.width/2) - (BALL_D/2), 
		canvas.height - PADDLE_H - BALL_D, BALL_I, BALL_D, BALL_D),
	      new Ball(canvas, 400, 400, BALL_I, BALL_D, BALL_D),
	      new Ball(canvas, 400, 400, BALL_I, BALL_D, BALL_D)];
	// TODO: set up bricks
		
	playing = true;
	bricks = newBricks(4, 11);	
	resetBoard();	
	interval = setInterval("gameStart()", 20);
	$(document).keydown(movePaddle);
	$(document).keyup(stopMovingPaddle);
};

