// Draw the bricks all pretty at the top
function drawBricks(bricks) {
	for (var i = 0; i < bricks.length; i++) {
		for (var j = 0; j < bricks[i].length; j++) {
			bricks[i][j].draw();
		}
	}
};

function newBricks(rows, cols) {
	var bricks = [];
	var current_x = 0;
	var current_y = 0;
	for (var i = 0; i < rows; i++) {
		var row = [];
		for (var j = 0; j < cols; j++) {
			row.push(new Brick(canvas, current_x, current_y, BRICK_I, 60, 50));
			current_x += BRICK_W;
		}
		current_y += BRICK_H;
		current_x = 0;
		bricks.push(row);
	}
	return bricks;
};

// Move the bottom paddle with mouse
function movePaddle() {
};

// Keep score
function addToScore() {
};

// Get rid of a ball
function dropBall() {
};

// Levels
function changeLevel() {
};

// Let's put all the if statements and magic up in hurr
function gamePlay(canvas) {
	document.onMouseMove = function(event) {
		// move paddle
	}
	// other things will go here, but i know this is part of it
	if (balls[0]){ 
		// change slope if ball hits edge 
		if (balls[0].x + dx > canvas.width || balls[0].x + dx < 0) dx = -dx;
		if (balls[0].y + dy < 0) dy = -dy;
		else if (balls[0].y + dy > canvas.height) {
			// if ball hits paddle, negate dy
			// if ball hits bottom
		//	else clearInterval(interval);
		}
		balls[0].x += dx;
		balls[0].y += dy;
	}
};


window.onload = function() {
	scoreSpan = document.getElementById("score");
	scoreSpan.innerHTML = score;
	
	canvas = document.getElementById("game-board");
	var ctx = canvas.getContext("2d");
	ctx.fillStyle="#FF0000";
	ctx.fillRect(0, 0, canvas.width, canvas.height);
	
	paddle = new Paddle(canvas, 400, PADDLE_I, PADDLE_W, PADDLE_H);
	balls = [new Ball(canvas, 400, 400, BALL_I, BALL_D, BALL_D),
	      new Ball(canvas, 400, 400, BALL_I, BALL_D, BALL_D),
	      new Ball(canvas, 400, 400, BALL_I, BALL_D, BALL_D)];
	// TODO: set up bricks
		
	playing = true;
	//interval = setInterval("gamePlay(canvas)", 20);
	paddle.draw();
	bricks = newBricks(4, 11);
	drawBricks(bricks);
};

