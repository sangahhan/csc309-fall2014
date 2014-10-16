function Brick(canvas, x, y, img, w, h, s) {
	GamePiece.call(this, canvas, x, y, img, w, h);
	this.score = s;
};

Brick.prototype = inheritFrom(GamePiece.prototype);
Brick.prototype.constructor = Brick;

Brick.prototype.testHit = function (ball) {
	var x_min = this.x;
	var x_max = x_min + this.width;
	var ball_left = ball.x;
	var ball_right = ball_left + ball.width;

	var y_min = this.y;
	var y_max = y_min + this.height;
	var ball_top = ball.y;
	var ball_bottom = ball_top + ball.height;
	
	var hitsSides = (ball_top >= y_min && ball_bottom <= y_max) 
		&& (ball_right == x_min || ball_left == x_max);
	var hitsTopBottom = (ball_left >= x_min && ball_right <= x_max) 
		&& (ball_bottom == y_min || ball_top == y_max);

	return (hitsSides || hitsTopBottom);
	return false;
}
