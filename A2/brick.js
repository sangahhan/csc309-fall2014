function Brick(canvas, x, y, img, w, h, s) {
	GamePiece.call(this, canvas, x, y, img, w, h);
	this.score = s;
};

Brick.prototype = inheritFrom(GamePiece.prototype);
Brick.prototype.constructor = Brick;

Brick.prototype.testHit = function (ball) {
	var x_min = this.x;
	var x_max = x_min + this.width;
	var y_min = this.y;
	var y_max = y_min + this.height;
	var ball_centre_x = ball.x + (ball.width / 2);
	// TODO: ball can only hit from bottom; make it so that it can hit from all around
	return ball_centre_x >= x_min && (ball_centre_x + ball.width) <= x_max && ball.y >= y_min && ball.y <= y_max;
}
