function Brick(canvas, x, y, img, w, h) {
	GamePiece.call(this, canvas, x, y, img, w, h);
	this.broken = false;
};

Brick.prototype = inheritFrom(GamePiece.prototype);
Brick.prototype.constructor = Brick;

Brick.prototype.testHit = function () {
}
