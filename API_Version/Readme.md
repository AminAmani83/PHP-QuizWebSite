// A. Quiz Topics

See all available topics, their IDs and their cover images:

http://localhost/API/quiz/topics

Example Response:

[{"id":"1","topic":"Animation","image":"http:\/\/localhost\/API\/img\/animation\/1.jpg"},{"id":"4","topic":"Logo","image":"http:\/\/localhost\/API\/img\/logo\/1.png"},{"id":"2","topic":"Movie","image":"http:\/\/localhost\/API\/img\/movie\/1.jpg"},{"id":"3","topic":"People","image":"http:\/\/localhost\/API\/img\/people\/1.jpg"},{"id":"5","topic":"Puzzle","image":"http:\/\/localhost\/API\/img\/puzzle\/1.jpg"}]


// B. Quiz Questions (only available to registered users)

Choose (n) questions from topic ID number (m):

http://localhost/API/quiz/m/n

Example URL:

http://localhost/API/quiz/1/3

Example Response:

[{"answer":"Ice Age","image":"http:\/\/localhost\/API\/img\/animation\/3.jpg"},{"answer":"Lion King","image":"http:\/\/localhost\/API\/img\/animation\/15.jpg"},{"answer":"Big Hero 6","image":"http:\/\/localhost\/API\/img\/animation\/17.jpg"}]


// C. Settings (only available to admin users)

View Admin Settings .

Example URL:

http://localhost/MyCode/7_API/quiz/private/game-settings

Example Response: (For now, temporaryly responding with the topics list)

[{"id":"1","topic":"Animation","image":"http:\/\/localhost\/API\/img\/animation\/1.jpg"},{"id":"4","topic":"Logo","image":"http:\/\/localhost\/API\/img\/logo\/1.png"},{"id":"2","topic":"Movie","image":"http:\/\/localhost\/API\/img\/movie\/1.jpg"},{"id":"3","topic":"People","image":"http:\/\/localhost\/API\/img\/people\/1.jpg"},{"id":"5","topic":"Puzzle","image":"http:\/\/localhost\/API\/img\/puzzle\/1.jpg"}]
