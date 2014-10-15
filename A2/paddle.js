function Paddle(canvas, x, img) {
	GamePiece.call(this, canvas, x, canvas.clientHeight - 30, img);
	this.width = 32;
};

Paddle.prototype = inheritFrom(GamePiece.prototype);
Paddle.prototype.constructor = Paddle;

