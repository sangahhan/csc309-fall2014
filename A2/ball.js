function Ball(canvas, x, y, img, diameter) {
	GamePiece.call(this, canvas, x, y ,img, diameter, diameter);
};

Ball.prototype = inheritFrom(GamePiece.prototype);
Ball.prototype.constructor = Ball;
var xdirection = -4;
var ydirection = -8;
Ball.prototype.draw = function () {
	var img = new Image();
	var ctx = this.context;
	var x = this.x;
	var y = this.y;
	var w = this.width;
	var h = this.height;
	ctx.beginPath();
	img.onload = function() {
		ctx.drawImage(img, x, y, w, h);
	}
	img.src = this.imgUrl;
	this.move();
	
};
Ball.prototype.move = function () {

	this.x += xdirection;
	
	if (this.x <= 0 || (this.x > canvas.width - BALL_D)){
		if (this.x <= 0){
			this.x = 0;
		} else {
			this.x = canvas.width - BALL_D;
		}
		xdirection = xdirection * -1;
	}

	this.y += ydirection;
	if (this.y <= 0 || (this.y > (canvas.height - PADDLE_H - BALL_D))){
		if (this.y <= 0){
			this.y = 0;
		} else {
			this.y = canvas.height - PADDLE_H - BALL_D;
		}	
		ydirection = ydirection * -1;
	}
}


