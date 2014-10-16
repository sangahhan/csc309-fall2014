function Brick(canvas, x, y, img, w, h, s) {
	GamePiece.call(this, canvas, x, y, img, w, h);
	this.score = s;
};

Brick.prototype = inheritFrom(GamePiece.prototype);
Brick.prototype.constructor = Brick;

Brick.prototype.testHit = function (ball) {
	var x_min = this.x;
	var y_min = this.y;
	var x_max = x_min + this.width - ball.width;
	var y_max = y_min + this.height;
	if ((ball.x >= x_min && ball.x <= x_max) 
			&& (ball.y >= y_min && ball.y <= y_max)) return true;
	return false;
}
