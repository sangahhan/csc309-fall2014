// Draw the bricks all pretty at the top
function setUpBricks() {
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
			else clearInterval(interval);
		}
		balls[0].x += dx;
		balls[0].y += dy;
	}
};


window.onload = function() {
	scoreSpan = document.getElementById("score");
	scoreSpan.innerHTML = score;
	
	canvas = document.getElementById("game-board");
	
	paddle = new Paddle(canvas, 400, "full4.png");
	balls = [new Ball(canvas, 400, 400, "football2.png"),
	      new Ball(canvas, 400, 400, "football2.png"),
	      new Ball(canvas, 400, 400, "football2.png")];
	// TODO: set up bricks
	
	playing = true;
	interval = setInterval("gamePlay(canvas)", 20);

	//var testBrick = new Brick(canvas, 0,0, "wall4.png");
	//testBrick.draw();
};

