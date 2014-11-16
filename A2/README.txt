- The ID of your AMI : ami-da189db2
- Access given to: 070162039798, 434525480428, 470901565805, 562973455468

- Location of your source files within the AMI : /var/www/html/A2

- Details about the browser the TA should use to test your assignment :
    Chrome or Firefox with min screen size 1280 x 800.

- Documentation for your Web site. Include a brief explanations of how it all
  works, e.g., list of main user-defined objects, and data structures.

NOTE : All of the javascript code for the game is located in js/breakout.js.
Other files were created for the sake of version control.

The data objects used :
-----------------------
Game piece
	- The parent class of Ball, Paddle and Brick.
	
Ball
	- Contains the location, and size details
	- Has the ability to move horizontally or vertically

Paddle
	- Contains the location and size details
	- Has the ability to move horizontally and to shrink itself

Brick
	- Stationary objects with location and the score

The data structures used:
-------------------------
- To keep track of balls and bricks left, we used 1D arrays.

  
How it works:
---------------

- Keep track of a variable called "playing" to indicate whether the user is
		playing or not.

When the user presses <Enter>, the game starts execution in intervals of
	30ms. At each interval, if the user is playing
	- Check to see if the ball hits a brick and update the score if it does.
		- This is where we check to see if the ball speed needs to be increased,
			update the score, remove the hit brick and bounce the ball off the
			hit brick as well.
    - Check to see if the ball hits the paddle
		- If it doesn't hit the paddle, then stop the game, reduce the number of
			balls. If there are more lives(balls) left, then reposition the paddle
			at the bottom center of the screen. Otherwise, indicate that the 
			player has lost.
		- If the ball does hit the paddle, then make sure that the direction
			of the ball is changed to go updwards.
	- Check to see if the user has won or completed level 1
		- If the score is 448, then the user has completed level 1.
			- We stop the game, reset the board (all game pieces except for the
				balls since we want to ball count to continue to level 2, place 
				the current ball on the paddle and indicate that the user has 
				moved up a level.
		- if the score is 896 or more, then the user has won. 
			- We stop the game, reset all variables and indicate that the player
				has won.

- We track to see if the left key or the right key is pressed to see
	if the paddle needs to be moved when drawing game pieces.

- When the user presses <Enter>,
	- if the user has not won yet, and there are more balls remaining,
		then the user just wants to pause or resume. To pause, check whether
		the user was playing, then stop the game. Otherwise, the user wants
		to resume the game so start game.
	- if the user has won or there are no balls left,
		then either the user has lost or won. So we need to stop the game,
		reset all the variables and game pieces which will take the game 
		state to the very beginning. This will put the game at the "pause" 
		state.

- To increase speed, keep track of how many units the ball travels in 
		each direction for each interval and increment it. 
	
	
