# ARCADE 

## Functions 
- get all available users
- get invitations
	- accept/ reject incoming invites- send invite 
- send invite 
	- if invite is accepted, proceed to board
	- inviter is u1; invitee is u2
	- change state of user depending on invite
		- When a user invites another user to play, the __inviter's__ status changes to waiting and the __invitee's__ status changes to invited
		- If the invitee accepts the invitation, the status of both users changes to playing. Otherwise, both users' status changes to available. 
		- When a user invites another user to battle, it create an entry in the __invite__ table with a status of pending. If the invitee accepts the invitation, the status changes to accepted and to rejected, otherwise. 
		- If an invitation to play is accepted, a new entry in the __match__ table is created with a status of active. The status changes to u1won or u2won when one of the users wins the game.

## Assumptions 

- An invitation will be answered eventually, i.e., no need to timeout invites

# BOARD 
i.e. gameplay

## Functions 
- get board state of a match
	- 2D Array 
	- deserialize from blob, return as JSON
- update board array -- "make a move"
	- check if the user who sent the request is playing the game. if not, return response status code = 401
	- check if the move is valid; if not, response status code = 400
		- a user can only add a disk on their turn
		- only 1 disk can be added at per turn
		- a disk can only be added in a column that is not already full
		- a disk can only be added to the first free open spot on a column

## Assumptions 
- A user can only be involved in 1 match at a time
- Once a match starts, it will continue until it finishes, i.e., users do not disappear or logout midway through

# ACCOUNT 

## Functions 

- login
- logout
- registration
	- salt + hash
	- use Securimage library-- has been added to application/libraries
- update password
- recover password
	- involves sending them a new randomized password 

