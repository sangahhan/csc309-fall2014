function Paddle(canvas, x, img, w, h) {
	GamePiece.call(this, canvas, x, canvas.height - h, img, w, h);
};

Paddle.prototype = inheritFrom(GamePiece.prototype);
Paddle.prototype.constructor = Paddle;

Paddle.prototype.draw = function() {
	var img = new Image();
	var ctx = this.context;
	var x = this.x - (this.width / 2);
	var y = this.y;
	var w = this.width;
	var h = this.height;
	ctx.beginPath();
	img.onload = function() {
		ctx.drawImage(img, x, y, w, h);
	}
	img.src = this.imgUrl;
};
