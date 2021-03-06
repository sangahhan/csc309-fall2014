function Paddle(canvas, x, img, w, h) {
	GamePiece.call(this, canvas, x, canvas.height - h, img, w, h);
	this.speed = 8;
};

Paddle.prototype = inheritFrom(GamePiece.prototype);
Paddle.prototype.constructor = Paddle;


Paddle.prototype.draw = function() {
	this.move();
	var ctx = this.context;
	ctx.fillStyle = this.bkg;
	ctx.beginPath();
	ctx.fillRect(this.x, this.y, this.width, this.height);
};

Paddle.prototype.move = function(){
	if (rightKeyPressed){
		this.x += this.speed;
		if (this.x + this.width > canvas.width) 
			this.x = canvas.width - this.width;
	} 
	if (leftKeyPressed){
		this.x -= this.speed;
		if (this.x < 0) this.x = 0;
	}
};

Paddle.prototype.shrinkSize = function(){
	this.width = this.width/2;
}